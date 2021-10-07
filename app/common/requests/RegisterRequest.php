<?php

namespace App\Common\Requests;

use Illuminate\Support\Str;
use App\Core\View\Request;
use App\Core\Http\Status;
use App\Core\Auth\{Account, User};
use App\Core\Data\Encryption;

/**
 * Action triggered during registration.
 *
 * @author  Pomianowski <kontakt@rapiddev.pl>
 * @license GPL-3.0 https://www.gnu.org/licenses/gpl-3.0.txt
 * @since   1.1.0
 */
final class RegisterRequest extends Request implements \App\Core\Schema\Request
{
  /** @see https://regex101.com/ */
  private const PASSWORD_PATTERN = "/(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[#$@!%&*?])[A-Za-z\d#$@!%&*?]+$/";

  private const PASSWORD_MIN_LENGTH = 8;

  private const PASSWORD_MAX_LENGTH = 128;

  public function getAction(): string
  {
    return 'Register';
  }

  public function process(): void
  {
    $this->isSet([
      'email',
      'password',
      'password_confirm',
    ]);

    $this->isEmpty([
      'email',
      'password',
      'password_confirm',
    ]);

    $this->validate([
      ['email'],
      ['password'],
      ['password_confirm']
    ]);

    if (Account::isRegistered($this->getData('email'))) {
      $this->addContent('fields', ['email']);
      $this->addContent('message', 'You cannot use this email address.');
      $this->finish(self::ERROR_ENTRY_EXISTS, Status::UNAUTHORIZED);
    }

    if (!preg_match(self::PASSWORD_PATTERN, $this->getData('password'))) {
      $this->addContent('fields', ['password']);
      $this->addContent('message', 'Password provided is too simple. It should contain a lowercase letter, an uppercase letter, a number and a special character.');
      $this->finish(self::ERROR_PASSWORD_TOO_SHORT, Status::UNAUTHORIZED);
    }

    if (Str::length($this->getData('password')) > self::PASSWORD_MAX_LENGTH) {
      $this->addContent('fields', ['password']);
      $this->addContent('message', 'Password provided is too long');
      $this->finish(self::ERROR_PASSWORD_TOO_SHORT, Status::UNAUTHORIZED);
    }

    if (Str::length($this->getData('password')) < self::PASSWORD_MIN_LENGTH) {
      $this->addContent('fields', ['password']);
      $this->addContent('message', 'Password provided is too short');
      $this->finish(self::ERROR_PASSWORD_TOO_SHORT, Status::UNAUTHORIZED);
    }

    if ($this->getData('password') != $this->getData('password_confirm')) {
      $this->addContent('fields', ['password_confirm']);
      $this->addContent('message', 'Passwords must be the same.');
      $this->finish(self::ERROR_PASSWORDS_DONT_MATCH, Status::UNAUTHORIZED);
    }

    if (! $this->registerUser()) {
      $this->finish(self::ERROR_INTERNAL_ERROR, Status::IM_A_TEAPOT);
    }

    $this->finish(self::CODE_SUCCESS, Status::OK);
  }

  private function registerUser(): bool
  {
    $encryptedPassword = Encryption::encrypt($this->getData('password'), 'password');

    $newUser = User::build([
      'display_name' => Str::before($this->getData('email'), '@'),
      'email' => $this->getData('email'),
      'password' => $encryptedPassword,
      'role' => Account::getRoleId('default')
    ]);

    return Account::register($newUser, $encryptedPassword);
  }
}
