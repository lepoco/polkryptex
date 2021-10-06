<?php

namespace App\Common\Requests;

use PDO;
use PDOException;
use Illuminate\Support\Str;
use App\Core\View\Request;
use App\Core\Auth\{Account, User};
use App\Core\Facades\{App, Logs, Config};
use App\Core\Data\{Encryption, Schema};
use App\Core\Utils\{Path, ClassInjector};

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

    ray($user);

    $this->finish(self::ERROR_INTERNAL_ERROR, self::STATUS_IM_A_TEAPOT);
  }

  private function registerUser(): bool
  {
    return true;
    //return Account::register($newUser, $encryptedPassword);
  }
}
