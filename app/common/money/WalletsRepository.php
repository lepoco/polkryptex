<?php

namespace App\Common\Money;

use App\Common\Money\Wallet;
use App\Core\Facades\DB;

/**
 * Contains the logic responsible for managing the wallets.
 *
 * @author  Pomianowski <support@polkryptex.pl>
 * @license GPL-3.0 https://www.gnu.org/licenses/gpl-3.0.txt
 * @since   1.1.0
 */
final class WalletsRepository
{
  public static function getUserWallets(int $id): array
  {
    $userWallets = [];
    $dbWallets = DB::table('wallets')->where(['user_id' => $id])->get()->all();

    foreach ($dbWallets as $singleWalletObject) {
      if (!isset($singleWalletObject->id) || !isset($singleWalletObject->user_id) || !isset($singleWalletObject->currency_id)) {
        continue;
      }

      $userWallets[] = self::fetchFromObject($singleWalletObject);
    }

    return $userWallets;
  }

  public static function addUserWallet(int $userId, Wallet $wallet): bool
  {
    if (0 >= $wallet->getCurrencyId()) {
      return false;
    }

    $wallet->setUserId($userId);

    return DB::table('wallets')->insert([
      'user_id' => $userId,
      'currency_id' => $wallet->getCurrencyId(),
      'virtual_balance' => $wallet->getBalance(),
      'created_at' => date('Y-m-d H:i:s'),
      'updated_at' => date('Y-m-d H:i:s')
    ]);
  }

  private static function fetchFromObject(object $db): Wallet
  {
    return Wallet::build([
      'id' => $db->id ?? 0,
      'user_id' => $db->user_id ?? 0,
      'currency_id' => $db->currency_id ?? 0,
      'balance' => $db->virtual_balance ?? 0,
      'created_at' => $db->created_at ?? '',
      'updated_at' => $db->updated_at ?? ''
    ]);
  }
}
