<?php

namespace App\Common\Composers;

use App\Core\View\Blade\Composer;
use App\Core\Facades\{Email, Translate};
use App\Core\Auth\{Account, Confirmation};
use App\Core\Http\Redirect;
use App\Core\Data\Encryption;
use Illuminate\View\View;

/**
 * Additional logic for the views/register-confirm.blade view.
 *
 * @author  Pomianowski <kontakt@rapiddev.pl>
 * @license GPL-3.0 https://www.gnu.org/licenses/gpl-3.0.txt
 * @since   1.0.0
 */
final class RegisterConfirmationComposer extends Composer implements \App\Core\Schema\Composer
{
  public function compose(View $view): void
  {
    if (!(isset($_GET['n']) && isset($_GET['e']) && isset($_GET['r']))) {
      $view->with('isValid', false);

      return;
    }

    $registartionNonce = htmlspecialchars($_GET['n']);
    $email = htmlspecialchars(urldecode($_GET['e']));
    $resendConfirmationToken = htmlspecialchars($_GET['r']);

    $user = Account::getBy('email', $email);

    if (empty($user) || $user->isConfirmed()) {
      $view->with('isValid', false);

      return;
    }

    $isTokenValid = Confirmation::isValid('resend_registration_confirmation', $user, $resendConfirmationToken);

    $view->with('resendLink', Redirect::url('register/confirmation', [
      'resend' => Encryption::encrypt('resend_confirmation', 'nonce'),
      'n' => $registartionNonce,
      'e' => urlencode($email),
      'r' => $resendConfirmationToken
    ]));

    $view->with('isResend', $this->resendLink($user));

    $view->with('isTokenValid', $isTokenValid);
    $view->with('isValid', true);
  }

  public function resendLink(\App\Core\Auth\User $user): bool
  {
    if (!isset($_GET['resend'])) {
      return false;
    }

    if (!Encryption::compare('resend_confirmation', $_GET['resend'], 'nonce')) {
      return false;
    }

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

    return true;
  }
}
