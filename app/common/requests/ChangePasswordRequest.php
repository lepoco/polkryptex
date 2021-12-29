<?php

namespace App\Common\Requests;

use App\Core\Facades\{Translate, Email};
use App\Core\View\Request;
use App\Core\Http\{Status, Redirect};
use App\Core\Auth\Account;
use App\Core\Auth\User;
use Illuminate\Support\Str;

/**
 * Action triggered during password change via account page.
 *
 * @author  Pomianowski <kontakt@rapiddev.pl>
 * @license GPL-3.0 https://www.gnu.org/licenses/gpl-3.0.txt
 * @since   1.1.0
 */
final class ChangePasswordRequest extends Request implements \App\Core\Schema\Request
{
  /** @see https://regex101.com/ */
  private const PASSWORD_PATTERN = "/(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^A-Za-z0-9])/";

  private const PASSWORD_MIN_LENGTH = 20;

  private const PASSWORD_MAX_LENGTH = 128;

  private User $user;

  public function getAction(): string
  {
    return 'ChangePassword';
  }

  public function process(): void
  {
    $this->isSet([
      'id',
      'current_password',
      'new_password',
      'new_password_confirm'
    ]);

    $this->isEmpty([
      'id',
      'current_password',
      'new_password',
      'new_password_confirm'
    ]);

    $this->validate([
      ['id', FILTER_VALIDATE_INT],
      ['current_password', FILTER_UNSAFE_RAW],
      ['new_password', FILTER_UNSAFE_RAW],
      ['new_password_confirm', FILTER_UNSAFE_RAW]
    ]);

    if (empty(Account::current())) {
      $this->finish(self::ERROR_USER_INVALID, Status::UNAUTHORIZED);
    }

    if ($this->get('id') < 1) {
      $this->finish(self::ERROR_USER_INVALID, Status::UNAUTHORIZED);
    }

    if ($this->get('id') !== Account::current()->getId()) {
      $this->finish(self::ERROR_USER_INVALID, Status::UNAUTHORIZED);
    }

    $this->user = new User((int) $this->get('id'));

    if (!$this->user->comparePassword($this->get('current_password'))) {
      $this->addContent('fields', ['current_password']);
      $this->addContent('message', Translate::string('Incorrect password.'));
      $this->finish(self::ERROR_PASSWORD_INVALID, Status::UNAUTHORIZED);
    }

    if ($this->get('new_password') != $this->get('new_password_confirm')) {
      $this->addContent('fields', ['new_password', 'new_password_confirm']);
      $this->addContent('message', Translate::string('Passwords must be the same.'));
      $this->finish(self::ERROR_PASSWORDS_DONT_MATCH, Status::UNAUTHORIZED);
    }

    if (Str::length($this->get('new_password')) < self::PASSWORD_MIN_LENGTH) {
      $this->addContent('fields', ['new_password']);
      $this->addContent('message', $this->passwordMessage());
      $this->finish(self::ERROR_PASSWORD_TOO_SHORT, Status::OK);
    }

    if (!preg_match(self::PASSWORD_PATTERN, $this->get('new_password'))) {
      $this->addContent('fields', ['new_password']);
      $this->addContent('message', $this->passwordMessage());
      $this->finish(self::ERROR_PASSWORD_TOO_SIMPLE, Status::OK);
    }

    if (Str::length($this->get('new_password')) > self::PASSWORD_MAX_LENGTH) {
      $this->addContent('fields', ['new_password']);
      $this->addContent('message', $this->passwordMessage());
      $this->finish(self::ERROR_PASSWORD_TOO_SHORT, Status::OK);
    }

    $this->user->updatePassword($this->get('new_password'));

    Email::send($this->user->getEmail(), [
      'subject' => Translate::string('Your password on the site has been changed'),
      'header' => Translate::string('Password changed!'),
      'message' => Translate::string('Your password has been updated, if you did not change it, contact the support and check the last activity on your devices.'),
      'action_title' => Translate::string('Sign in'),
      'action_url' => Redirect::url('signin')
    ]);

    $this->addContent('message', Translate::string('Your new password has been saved.'));
    $this->finish(self::CODE_SUCCESS, Status::OK);
  }

  private function passwordMessage(): string
  {
    return sprintf(
      Translate::string('The password provided is too simple. It should be %s to %s characters long and contain a lowercase letter, an uppercase letter, a number and a special character.'),
      self::PASSWORD_MIN_LENGTH,
      self::PASSWORD_MAX_LENGTH
    );
  }
}
