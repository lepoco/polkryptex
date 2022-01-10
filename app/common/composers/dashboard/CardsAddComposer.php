<?php

namespace App\Common\Composers\Dashboard;

use App\Core\Auth\Account;
use App\Core\View\Blade\Composer;
use Illuminate\View\View;

/**
 * Additional logic for the views/dashboard/cards-add.blade view.
 *
 * @author  Pomianowski <support@polkryptex.pl>
 * @license GPL-3.0 https://www.gnu.org/licenses/gpl-3.0.txt
 * @since   1.0.0
 */
final class CardsAddComposer extends Composer implements \App\Core\Schema\Composer
{
  public function compose(View $view): void
  {
    $user = Account::current();

    $view->with('user', $user);
  }
}
