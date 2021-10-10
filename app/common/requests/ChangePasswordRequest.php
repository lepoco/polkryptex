<?php

namespace App\Common\Requests;

use App\Core\View\Request;
use App\Core\Http\Status;
use App\Core\Auth\Account;
use App\Core\Auth\User;

/**
 * Action triggered during password change via account page.
 *
 * @author  Pomianowski <kontakt@rapiddev.pl>
 * @license GPL-3.0 https://www.gnu.org/licenses/gpl-3.0.txt
 * @since   1.1.0
 */
final class ChangePasswordRequest extends Request implements \App\Core\Schema\Request
{
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

    $user = new User((int) $this->getData('id'));
  }
}
