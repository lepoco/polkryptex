<?php

namespace App\Common\Composers\Dashboard;

use App\Core\Facades\{Email, Translate};
use App\Core\Auth\{Account, User, Confirmation};
use App\Core\Data\Encryption;
use App\Core\View\Blade\Composer;
use App\Core\Http\Redirect;
use Illuminate\View\View;

/**
 * Additional logic for the views/dashboard/main.blade view.
 *
 * @author  Pomianowski <kontakt@rapiddev.pl>
 * @license GPL-3.0 https://www.gnu.org/licenses/gpl-3.0.txt
 * @since   1.0.0
 */
final class UnconfirmedComposer extends Composer implements \App\Core\Schema\Composer
{
  public function compose(View $view): void
  {
    $user = Account::current();

    if ($user->isConfirmed()) {
      Redirect::to('dashboard');
    }

    if (isset($_GET['resend']) && isset($_GET['token']) && Confirmation::isValid('resend_registration_confirmation', $user, $_GET['token'])) {
      $this->resendConfirmation($user);
    }

    // Update token every time
    $resendConfirmation = Confirmation::add('resend_registration_confirmation', $user);

    $view->with('user', $user);
    $view->with('resendLink', Redirect::url('dashboard/unconfirmed', [
      'resend' => Encryption::hash('resend_confirmation', 'nonce'),
      'email' => urlencode($user->getEmail()),
      'token' => $resendConfirmation
    ]));
  }

  private function resendConfirmation(User $user)
  {
    Email::send($user->getEmail(), [
      'subject' => Translate::string('Thank you for your registration!'),
      'header' => Translate::string('Account confirmation'),
      'message' => Translate::string('Thank you for creating an account on our website. Click on the link below to activate your account.'),
      'action_title' => Translate::string('Confirm email'),
      'action_url' => Redirect::url('register/confirm', [
        'confirmation' => Confirmation::add('registration_confirmation', $user),
        'email' => urlencode($user->getEmail())
      ])
    ]);
    ray('resend');
  }
}
