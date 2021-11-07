<?php

namespace App\Common\Composers\Dashboard;

use App\Common\Money\{TransactionsRepository, Transaction};
use App\Core\Facades\Request;
use App\Core\Auth\Account;
use App\Core\View\Blade\Composer;
use Illuminate\View\View;

/**
 * Additional logic for the views/dashboard/transaction.blade view.
 *
 * @author  Pomianowski <kontakt@rapiddev.pl>
 * @license GPL-3.0 https://www.gnu.org/licenses/gpl-3.0.txt
 * @since   1.0.0
 */
final class TransactionComposer extends Composer implements \App\Core\Schema\Composer
{
  public function compose(View $view): void
  {
    $segments = Request::segments();
    $user = Account::current();
    $transaction = null;

    if (isset($segments[2])) {
      $transaction = $this->getTransaction($segments[2]);
    }

    // If the transaction was not sent by the user
    // TODO: If a user is a receiver
    if (!empty($transaction) && $transaction->getUser()->getId() !== $user->getId()) {
      $transaction = null;
    }

    $view->with('user', $user);
    $view->with('transaction', $transaction);
    $view->with('currency', $transaction->getWalletTo()->getCurrency());
    $view->with('is_valid', !empty($transaction));
  }

  private function getTransaction(string $uuid): ?Transaction
  {
    return TransactionsRepository::getBy('uuid', $uuid);
  }
}
