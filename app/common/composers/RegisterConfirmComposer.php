<?php

namespace App\Common\Composers;

use App\Core\View\Blade\Composer;
use App\Core\Auth\{Account, Confirmation};
use Illuminate\View\View;

/**
 * Additional logic for the views/register-confirm.blade view.
 *
 * @author  Pomianowski <kontakt@rapiddev.pl>
 * @license GPL-3.0 https://www.gnu.org/licenses/gpl-3.0.txt
 * @since   1.0.0
 */
final class RegisterConfirmComposer extends Composer implements \App\Core\Schema\Composer
{
  public function compose(View $view): void
  {
    if (!(isset($_GET['email']) && isset($_GET['confirmation']))) {
      $view->with('isValid', false);

      return;
    }

    $confirmation = htmlspecialchars($_GET['confirmation']);
    $email = htmlspecialchars(urldecode($_GET['email']));

    $user = Account::getBy('email', $email);

    if (empty($user) || $user->isConfirmed()) {
      $view->with('isValid', false);

      return;
    }

    $isConfirmed = Confirmation::isValid('registration_confirmation', $user, $confirmation);

    if (!$isConfirmed) {
      $view->with('isValid', false);

      return;
    }

    Confirmation::markConfirmed('registration_confirmation', $user);

    $user->markAsConfirmed();
    $user->update();

    $view->with('user', $user);
    $view->with('email', $email);
    $view->with('confirmation', $confirmation);

    $view->with('isValid', true);
  }
}
