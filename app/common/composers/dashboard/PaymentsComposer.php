<?php

namespace App\Common\Composers\Dashboard;

use App\Common\Money\TransactionsRepository;
use App\Core\Auth\{User, Account};
use App\Core\Http\Redirect;
use App\Core\View\Blade\Composer;
use Illuminate\View\View;
use Illuminate\Support\Str;

/**
 * Additional logic for the views/dashboard/payments.blade view.
 *
 * @author  Pomianowski <kontakt@rapiddev.pl>
 * @license GPL-3.0 https://www.gnu.org/licenses/gpl-3.0.txt
 * @since   1.0.0
 */
final class PaymentsComposer extends Composer implements \App\Core\Schema\Composer
{
  public function compose(View $view): void
  {
    $user = Account::current();
    $payments = $this->getPayments($user);

    $view->with('user', $user);
    $view->with('payments', $payments);
    $view->with('has_payments', !empty($payments));
  }

  private function getPayments(User $user): array
  {
    return TransactionsRepository::getUserTransactions('transfer', 5, 0);
  }
}
