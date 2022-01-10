<?php

namespace App\Common\Composers\Panel;

use App\Core\Facades\Request;
use App\Core\Auth\{Account, User};
use App\Core\View\Blade\Composer;
use App\Core\Http\Redirect;
use Illuminate\View\View;

/**
 * Additional logic for the views/panel/user.blade view.
 *
 * @author  Pomianowski <support@polkryptex.pl>
 * @license GPL-3.0 https://www.gnu.org/licenses/gpl-3.0.txt
 * @since   1.0.0
 */
final class UserComposer extends Composer implements \App\Core\Schema\Composer
{
  public function compose(View $view): void
  {
    $segments = Request::segments();
    $user = Account::current();

    $view->with('user', null);

    if (isset($segments[2])) {
      $user = Account::getBy('uuid', $segments[2]);
    } else {
      Redirect::to('panel/users');
    }

    $view->with('user', $user);
  }
}
