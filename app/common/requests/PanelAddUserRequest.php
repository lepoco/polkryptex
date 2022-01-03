<?php

namespace App\Common\Requests;

use App\Core\View\Request;
use App\Core\Http\Status;
use App\Core\Auth\{Account, User, Permission, Confirmation};
use App\Core\Data\Encryption;

/**
 * Action triggered during signing in.
 *
 * @author  Kujawski <szymonspam@wp.pl>
 * @license GPL-3.0 https://www.gnu.org/licenses/gpl-3.0.txt
 * @since   1.1.0
 */
final class PanelAddUserRequest extends Request implements \App\Core\Schema\Request
{
  public function getAction(): string
  {
    return 'PanelAddUser';
  }

  public function process(): void
  {
    $this->isSet([
      'user_role',
      'user_email',
      'user_display_name',
      'user_password',
      'user_password_confirm'
    ]);

    $this->isEmpty([
      'user_role',
      'user_email',
      'user_display_name',
      'user_password',
      'user_password_confirm'
    ]);

    $this->validate([
      ['user_role', self::SANITIZE_STRING], 
      ['user_email', FILTER_VALIDATE_EMAIL],
      ['user_display_name', self::SANITIZE_STRING],
      ['user_password', FILTER_UNSAFE_RAW],
      ['user_password_confirm', FILTER_UNSAFE_RAW],
    ]);

    if (Account::isRegistered($this->get('user_email'))) {
      $this->addContent('fields', ['user_email']);
      $this->addContent('message', 'You cannot use this email address.');
      $this->finish(self::ERROR_ENTRY_EXISTS, Status::OK);
    }

    if($this->get('user_password') !== $this->get('user_password_confirm')){
      $this->addContent('message', 'Password doesn\'t match');
      $this->addContent('fields', ['user_password', 'user_password_confirm']);
      $this->finish(self::ERROR_PASSWORDS_DONT_MATCH, Status::OK);
    }
    
    $encryptedPassword = Encryption::hash(
      $this->get('user_password'),
      'password'
    );

    $newUser = (User::build([
      'display_name' => $this->get('user_display_name'),
      'email' => $this->get('user_email'),
      'password' => $encryptedPassword,
      'role' => Permission::getRoleId($this->get('user_role'))
    ]))
      ->markAsActive()
      ->markAsConfirmed();

    Account::register($newUser, $encryptedPassword);

    $this->addContent('message', 'User registred!');
    $this->finish(self::CODE_SUCCESS, Status::OK);
  }
}
