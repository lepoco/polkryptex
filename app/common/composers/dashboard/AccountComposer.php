<?php

namespace App\Common\Composers\Dashboard;

use App\Core\Auth\Account;
use App\Core\View\Blade\Composer;
use Illuminate\View\View;
use App\Common\Money\CardRepository;
use App\Core\Facades\Email;
use App\Core\Facades\Translate;
use App\Core\Http\Redirect;

/**
 * Additional logic for the views/dashboard/account.blade view.
 *
 * @author  Pomianowski <support@polkryptex.pl>
 * @license GPL-3.0 https://www.gnu.org/licenses/gpl-3.0.txt
 * @since   1.0.0
 */
final class AccountComposer extends Composer implements \App\Core\Schema\Composer
{
  public function compose(View $view): void
  {
    $user = Account::current();

    $view->with('has_profile_picture', !empty($user->getImage(false)));
    $view->with('user', Account::current());
    $view->with('user_cards', CardRepository::getUserCards($user));
  }
}
