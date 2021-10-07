<?php

namespace App\Common\Requests;

use App\Core\View\Request;
use App\Core\Auth\Account;

/**
 * Action triggered during app installation.
 *
 * @author  Pomianowski <kontakt@rapiddev.pl>
 * @license GPL-3.0 https://www.gnu.org/licenses/gpl-3.0.txt
 * @since   1.1.0
 */
final class SignInRequest extends Request implements \App\Core\Schema\Request
{
  public function getAction(): string
  {
    return 'SignIn';
  }

  public function process(): void
  {
    $this->isSet([
      'email',
      'password'
    ]);

    $this->isEmpty([
      'email',
      'password'
    ]);

    $this->validate([
      ['email'],
      ['password']
    ]);

    $user = Account::getBy('email', $this->getData('email'));

    if (empty($user)) {
      $this->unauthorizedRequest();

      return;
    }

    if (!$user->comparePassword($this->getData('password'))) {
      $this->unauthorizedRequest();

      return;
    }

    if (!Account::signIn($user)) {
      $this->finish(self::ERROR_INTERNAL_ERROR, self::STATUS_IM_A_TEAPOT);
    }

    $this->finish(self::CODE_SUCCESS, self::STATUS_OK);
  }

  private function unauthorizedRequest(): void
  {
    $this->addContent('fields', ['email', 'password']);
    $this->addContent('message', 'Incorrect login details.');
    $this->finish(self::ERROR_USER_INVALID, self::STATUS_UNAUTHORIZED);
  }
}
