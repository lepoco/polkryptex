<?php

namespace App\Common\Requests;

use App\Core\View\Request;
use App\Core\Http\Status;
use App\Core\Auth\{Account, User};
use App\Core\Facades\{Translate, Statistics};
use App\Common\Users\Billing;

/**
 * Action triggered during update of account billing.
 *
 * @author  Pomianowski <kontakt@rapiddev.pl>
 * @license GPL-3.0 https://www.gnu.org/licenses/gpl-3.0.txt
 * @since   1.1.0
 */
final class UpdateBillingRequest extends Request implements \App\Core\Schema\Request
{
  public function getAction(): string
  {
    return 'UpdateBilling';
  }

  public function process(): void
  {
    $this->isSet([
      'id',
      'first_name',
      'last_name',
      'street',
      'postal_code',
      'city',
      'province',
      'country',
      'phone',
      'email'
    ]);

    $this->isEmpty([
      'id',
      'first_name',
      'last_name',
      'street',
      'postal_code',
      'city',
      'province',
      'country',
      'phone',
      'email'
    ]);

    $this->validate([
      ['id', FILTER_VALIDATE_INT],
      ['first_name', FILTER_SANITIZE_STRING],
      ['last_name', FILTER_SANITIZE_STRING],
      ['street', FILTER_SANITIZE_STRING],
      ['postal_code', FILTER_SANITIZE_STRING],
      ['city', FILTER_SANITIZE_STRING],
      ['province', FILTER_SANITIZE_STRING],
      ['country', FILTER_SANITIZE_STRING],
      ['phone', FILTER_SANITIZE_STRING],
      ['email', FILTER_VALIDATE_EMAIL]
    ]);

    if (!Account::isLoggedIn()) {
      $this->finish(self::ERROR_USER_INVALID, Status::UNAUTHORIZED);

      return;
    }

    if ($this->get('id') < 1) {
      $this->finish(self::ERROR_USER_INVALID, Status::UNAUTHORIZED);

      return;
    }

    if ($this->get('id') !== Account::current()->getId()) {
      $this->finish(self::ERROR_USER_INVALID, Status::UNAUTHORIZED);

      return;
    }

    // TODO: Validate input data

    $user = new User((int) $this->get('id'));

    if (!Account::hasPermission('billing', $user)) {
      $this->addContent('message', Translate::string('You are not authorized to perform this action.'));
      $this->finish(self::ERROR_USER_INVALID, Status::UNAUTHORIZED);

      return;
    }

    $billing = new Billing($user->id());

    $billing
      ->setFirstName($this->get('first_name'))
      ->setLastName($this->get('last_name'))
      ->setStreet($this->get('street'))
      ->setPostalCode($this->get('postal_code'))
      ->setCity($this->get('city'))
      ->setCountry($this->get('country'))
      ->setProvince($this->get('province'))
      ->setPhone($this->get('phone'))
      ->setEmail($this->get('email'))
      ->update();

    $this->addContent('message', Translate::string('Your billing details have been saved.'));
    $this->finish(self::CODE_SUCCESS, Status::OK);
  }
}
