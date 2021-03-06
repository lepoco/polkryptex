<?php

namespace App\Common\Money;

use App\Core\Auth\Account;
use App\Core\Facades\{DB, Cache};
use App\Core\Auth\User;
use Illuminate\Support\Str;

/**
 * Contains the logic responsible for managing the transactions.
 *
 * @author  Pomianowski <support@polkryptex.pl>
 * @license GPL-3.0 https://www.gnu.org/licenses/gpl-3.0.txt
 * @since   1.1.0
 */
final class TransactionsRepository
{
  private const ROUND_PLACES = 12;

  public static function topup(User $user, Wallet $wallet, float $amount, string $method): bool
  {
    $currentBalance = round($wallet->getBalance(), self::ROUND_PLACES);
    $newBalance = round($currentBalance + $amount, self::ROUND_PLACES);

    $wallet->updateBalance($newBalance);

    return self::makeTopup($user, $wallet, $amount, $method);
  }

  public static function transfer(Wallet $from, Wallet $to, float $amount): bool
  {
    $fromStartingBalance = round($from->getBalance(), self::ROUND_PLACES);
    $toStartingBalance = round($to->getBalance(), self::ROUND_PLACES);

    $fromCurrencyRate = round($from->getCurrency()->getRate(), self::ROUND_PLACES);
    $toCurrencyRate = round($to->getCurrency()->getRate(), self::ROUND_PLACES);

    $usdValue = round($amount / $fromCurrencyRate, 6);

    $fromNewBalance = round($fromStartingBalance - $amount, 6);
    $toNewBalance = round($toStartingBalance + ($usdValue * $toCurrencyRate), 6);

    $from->updateBalance($fromNewBalance);
    $to->updateBalance($toNewBalance);

    return self::makeTransfer($from, $to, $usdValue);
  }

  public static function exchange(Wallet $from, Wallet $to, float $amount): bool
  {
    $fromStartingBalance = round($from->getBalance(), self::ROUND_PLACES);
    $toStartingBalance = round($to->getBalance(), self::ROUND_PLACES);

    $fromCurrencyRate = round($from->getCurrency()->getRate(), self::ROUND_PLACES);
    $toCurrencyRate = round($to->getCurrency()->getRate(), self::ROUND_PLACES);

    $usdValue = round($amount / $fromCurrencyRate, 6);

    $fromNewBalance = round($fromStartingBalance - $amount, 6);
    $toNewBalance = round($toStartingBalance + ($usdValue * $toCurrencyRate), 6);

    $from->updateBalance($fromNewBalance);
    $to->updateBalance($toNewBalance);

    return self::makeExchange($from, $to, $usdValue);
  }

  public static function getBy(string $key, mixed $value): ?Transaction
  {
    $transactionId = Cache::remember('transaction.getBy.' . $key . '.' . crc32($value), 3600, function () use ($key, $value) {
      $query = DB::table('transactions')->where($key, 'LIKE', $value)->get(['id'])->first();

      if (!isset($query->id)) {
        return 0;
      }

      return $query->id;
    });

    if (0 === $transactionId) {
      return null;
    }

    return new Transaction($transactionId);
  }

  /**
   * @return \App\Coore\Money\Transaction[]
   */
  public static function getUserTransactions(string $type, int $limit = 20, int $offset = 0, ?User $user = null): array
  {
    $user = empty($user) ? Account::current() : $user;
    $transactions = [];

    if (empty($user)) {
      return [];
    }

    $arguments = [
      'user_id' => $user->getId()
    ];

    if ('all' !== $type) {
      $arguments['type_id'] = self::getTypeId($type);
    }

    // $results = Cache::remember(
    //   'transactions.list.off' . $offset . '.user_' . $user->getId(),
    //   120,
    //   fn () => DB::table('transactions')->orderBy('id', 'desc')->where($arguments)->skip($offset)->take($limit)->get(['id'])
    // );
    $results = DB::table('transactions')->orderBy('id', 'desc')->where($arguments)->skip($offset)->take($limit)->get(['id']);

    foreach ($results as $result) {
      if (isset($result->id)) {
        $transactions[] = new Transaction($result->id);
      }
    }

    return $transactions;
  }

  private static function makeTransaction(User $user, Wallet $fromWallet, Wallet $toWallet, float $amount): bool
  {
    return DB::table('transactions')->insert([
      'user_id' => $user->getId(),
      'wallet_from' => $fromWallet->getId(),
      'wallet_to' => $toWallet->getId(),
      'amount' => $amount,
      'is_topup' => false,
      'method_id' => self::getMethodId('transfer'),
      'type_id' => self::getTypeId('topup'),
      'uuid' => Str::uuid(),
      'created_at' => date('Y-m-d H:i:s')
    ]);
  }

  public static function getMethodId(string $key): int
  {
    return Cache::forever('transaction.method_id.' . $key, function () use ($key) {
      $dbKey = DB::table('transaction_method')->where(['name' => $key])->get(['id'])->first();

      if (isset($dbKey->id)) {
        return $dbKey->id;
      }

      $insertedId = DB::table('transaction_method')->insertGetId([
        'name' => $key
      ]);

      return $insertedId;
    });
  }

  public static function getMethodName(int $id): string
  {
    return Cache::remember('transaction.method_name.' . $id, 120, function () use ($id) {
      $dbKey = DB::table('transaction_method')->where(['id' => $id])->get(['name'])->first();

      if (isset($dbKey->name)) {
        return $dbKey->name;
      }

      return '';
    });
  }

  public static function getTypeId(string $key): int
  {
    return Cache::forever('transaction.type_id.' . $key, function () use ($key) {
      $dbKey = DB::table('transaction_type')->where(['name' => $key])->get(['id'])->first();

      if (isset($dbKey->id)) {
        return $dbKey->id;
      }

      $insertedId = DB::table('transaction_type')->insertGetId([
        'name' => $key
      ]);

      return $insertedId;
    });
  }

  public static function getTypeName(int $id): string
  {
    return Cache::remember('transaction.type_name.' . $id, 120, function () use ($id) {
      $dbKey = DB::table('transaction_type')->where(['id' => $id])->get(['name'])->first();

      if (isset($dbKey->name)) {
        return $dbKey->name;
      }

      return '';
    });
  }

  private static function makeTopup(User $user, Wallet $toWallet, float $amount, string $method): bool
  {
    // TODO: Make methods a separate table
    return DB::table('transactions')->insert([
      'user_id' => $user->getId(),
      'wallet_to' => $toWallet->getId(),
      'amount' => $amount,
      'is_topup' => true,
      'uuid' => Str::uuid(),
      'method_id' => self::getMethodId($method),
      'type_id' => self::getTypeId('topup'),
      'created_at' => date('Y-m-d H:i:s')
    ]);
  }

  private static function makeTransfer(Wallet $fromWallet, Wallet $toWallet, float $amount): bool
  {
    DB::table('transactions')->insert([
      'user_id' => $fromWallet->getUserId(),
      'wallet_from' => $fromWallet->getId(),
      'wallet_to' => $toWallet->getId(),
      'amount' => -$amount,
      'is_topup' => false,
      'rate' => $fromWallet->getCurrency()->getRate(),
      'uuid' => Str::uuid(),
      'type_id' => self::getTypeId('transfer'),
      'method_id' => self::getMethodId('internal'),
      'created_at' => date('Y-m-d H:i:s')
    ]);

    return DB::table('transactions')->insert([
      'user_id' => $toWallet->getUserId(),
      'wallet_from' => $fromWallet->getId(),
      'wallet_to' => $toWallet->getId(),
      'amount' => $amount,
      'is_topup' => false,
      'rate' => $toWallet->getCurrency()->getRate(),
      'uuid' => Str::uuid(),
      'type_id' => self::getTypeId('transfer'),
      'method_id' => self::getMethodId('internal'),
      'created_at' => date('Y-m-d H:i:s')
    ]);
  }

  private static function makeExchange(Wallet $fromWallet, Wallet $toWallet, float $amount): bool
  {
    DB::table('transactions')->insert([
      'user_id' => $fromWallet->getUserId(),
      'wallet_from' => $fromWallet->getId(),
      'wallet_to' => $toWallet->getId(),
      'amount' => -$amount,
      'is_topup' => false,
      'rate' => $fromWallet->getCurrency()->getRate(),
      'uuid' => Str::uuid(),
      'type_id' => self::getTypeId('exchange'),
      'method_id' => self::getMethodId('internal'),
      'created_at' => date('Y-m-d H:i:s')
    ]);

    return DB::table('transactions')->insert([
      'user_id' => $toWallet->getUserId(),
      'wallet_from' => $fromWallet->getId(),
      'wallet_to' => $toWallet->getId(),
      'amount' => $amount,
      'is_topup' => false,
      'rate' => $toWallet->getCurrency()->getRate(),
      'uuid' => Str::uuid(),
      'type_id' => self::getTypeId('exchange'),
      'method_id' => self::getMethodId('internal'),
      'created_at' => date('Y-m-d H:i:s')
    ]);
  }
}
