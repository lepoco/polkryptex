<?php

namespace App\Common\Composers\Dashboard;

use App\Common\Money\{TransactionsRepository, WalletsRepository};
use App\Core\Auth\{Account, User};
use App\Core\View\Blade\Composer;
use Illuminate\View\View;

/**
 * Additional logic for the views/dashboard/main.blade view.
 *
 * @author  Pomianowski <support@polkryptex.pl>
 * @license GPL-3.0 https://www.gnu.org/licenses/gpl-3.0.txt
 * @since   1.0.0
 */
final class MainComposer extends Composer implements \App\Core\Schema\Composer
{
  public function compose(View $view): void
  {
    $user = Account::current();

    $recentTransactions = $this->getRecentTransactions($user);
    $wallets = WalletsRepository::getUserWallets($user->getId());

    $view->with('user', $user);
    $view->with('wallets', $wallets);
    $view->with('wallets_total', $this->getTotalWalletsAmount($wallets));
    $view->with('recent_transactions', $recentTransactions);
    $view->with('has_transactions', !empty($recentTransactions));
  }

  private function getRecentTransactions(User $user): array
  {
    return TransactionsRepository::getUserTransactions('all', 5, 0, $user);
  }

  private function getTotalWalletsAmount(array $wallets): float
  {
    $totalAmount = 0;

    foreach ($wallets as $wallet) {
      // ray([
      //   'total' => $totalAmount,
      //   'currency' => $wallet->getCurrency()->getIsoCode(),
      //   'amount' => $wallet->getBalance(),
      //   'rate' => $wallet->getCurrency()->getRate(),
      //   'compiled' => $wallet->getBalance() / $wallet->getCurrency()->getRate(),
      //   'total_after' => $totalAmount + ($wallet->getBalance() / $wallet->getCurrency()->getRate())
      // ]);

      $totalAmount += $wallet->getBalance() / $wallet->getCurrency()->getRate();
    }

    return $totalAmount;
  }
}
