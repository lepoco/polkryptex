<?php

namespace App\Common\Composers\Dashboard;

use App\Core\Auth\Account;
use App\Core\View\Blade\Composer;
use App\Common\Users\Billing;
use Illuminate\View\View;

/**
 * Additional logic for the views/dashboard/billing.blade view.
 *
 * @author  Pomianowski <support@polkryptex.pl>
 * @license GPL-3.0 https://www.gnu.org/licenses/gpl-3.0.txt
 * @since   1.0.0
 */
final class BillingComposer extends Composer implements \App\Core\Schema\Composer
{
  public function compose(View $view): void
  {
    $user = Account::current();

    $view->with('user', $user);
    $view->with('billing', new Billing($user->id()));
  }
}
