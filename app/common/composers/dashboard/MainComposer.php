<?php

namespace App\Common\Composers\Dashboard;

use App\Common\Money\TransactionsRepository;
use App\Core\Auth\{Account, User};
use App\Core\View\Blade\Composer;
use App\Core\Http\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Str;

/**
 * Additional logic for the views/dashboard/main.blade view.
 *
 * @author  Pomianowski <kontakt@rapiddev.pl>
 * @license GPL-3.0 https://www.gnu.org/licenses/gpl-3.0.txt
 * @since   1.0.0
 */
final class MainComposer extends Composer implements \App\Core\Schema\Composer
{
  public function compose(View $view): void
  {
    $user = Account::current();
    $recentTransactions = $this->getRecentTransactions($user);

    $view->with('user', $user);
    $view->with('recent_transactions', $recentTransactions);
    $view->with('has_transactions', !empty($recentTransactions));
  }

  private function getRecentTransactions(User $user): array
  {
    $transactions = TransactionsRepository::getUserTransactions('all', 5);
    $parsedTransactions = [];
    $types = [];
    $methods = [];
    $wallets = [];
    $currencies = [];

    foreach ($transactions as $singleTransaction) {
      $typeId = $singleTransaction->getTypeId();
      $methodId = $singleTransaction->getMethodId();

      if (!in_array($typeId, $types)) {
        $types[$typeId] = TransactionsRepository::getTypeName($typeId);
      }

      if (!in_array($methodId, $methods)) {
        $methods[$methodId] = TransactionsRepository::getMethodName($methodId);
      }

      $parsedTransactions[] = [
        'url' => Redirect::url('dashboard/transaction/' . $singleTransaction->getUUID()),
        'amount' => $singleTransaction->getAmount(),
        'date' => $singleTransaction->getCreatedAt(),
        'type' => $types[$typeId],
        'method' => $methods[$methodId],
        'currency' => $singleTransaction->getWalletTo()->getCurrency()
      ];
    }

    return $parsedTransactions;
  }
}
