<?php

namespace App\Common\Money;

use App\Core\Facades\DB;
use App\Core\Auth\User;
use Illuminate\Support\Str;

/**
 * Contains the logic responsible for managing the transactions.
 *
 * @author  Pomianowski <kontakt@rapiddev.pl>
 * @license GPL-3.0 https://www.gnu.org/licenses/gpl-3.0.txt
 * @since   1.1.0
 */
final class TransactionsRepository
{
  public static function topup(User $user, Wallet $wallet, float $amount, string $method): bool
  {
    $currentBalance = $wallet->getBalance();
    $newBalance = $currentBalance + $amount;

    $wallet->updateBalance($newBalance);

    return self::makeTopup($user, $wallet, $amount, $method);
  }

  public static function transfer(Wallet $from, Wallet $to, float $amount): bool
  {
    return false;
  }

  public static function exchange(Wallet $from, Wallet $to, float $amount, float $rate): bool
  {
    return false;
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
    $dbKey = DB::table('transaction_method')->where(['name' => $key])->get(['id'])->first();

    if (isset($dbKey->id)) {
      return $dbKey->id;
    }

    $insertedId = DB::table('transaction_method')->insertGetId([
      'name' => $key
    ]);

    return $insertedId;
  }

  public static function getTypeId(string $key): int
  {
    $dbKey = DB::table('transaction_type')->where(['name' => $key])->get(['id'])->first();

    if (isset($dbKey->id)) {
      return $dbKey->id;
    }

    $insertedId = DB::table('transaction_type')->insertGetId([
      'name' => $key
    ]);

    return $insertedId;
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
}
