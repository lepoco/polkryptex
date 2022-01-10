<?php

namespace App\Common\Requests;

use App\Core\View\Request;
use App\Core\Http\Status;
use App\Core\Auth\Account;
use App\Core\Facades\Translate;
use App\Common\Money\{CardRepository, Card};
use App\Core\Http\Redirect;

/**
 * Action triggered during adding new card.
 *
 * @author  Pomianowski <support@polkryptex.pl>
 * @license GPL-3.0 https://www.gnu.org/licenses/gpl-3.0.txt
 * @since   1.1.0
 */
final class AddCardRequest extends Request implements \App\Core\Schema\Request
{
  public function getAction(): string
  {
    return 'AddCard';
  }

  public function process(): void
  {
    $this->isSet([
      'id',
      'card_number',
      'card_name',
      'card_expiration_date',
      'card_security_code'
    ]);

    $this->isEmpty([
      'id',
      'card_number',
      'card_name',
      'card_expiration_date',
      'card_security_code'
    ]);

    $this->validate([
      ['id', FILTER_VALIDATE_INT],
      ['card_number', self::SANITIZE_STRING],
      ['card_name', self::SANITIZE_STRING],
      ['card_expiration_date', self::SANITIZE_STRING],
      ['card_security_code', FILTER_VALIDATE_INT],
    ]);

    $user = Account::current();

    if (empty($user)) {
      $this->finish(self::ERROR_USER_INVALID, Status::UNAUTHORIZED);

      return;
    }

    $cardHolder = trim($this->get('card_name'));
    $cardNumber = preg_replace('/[^0-9]+/', '', $this->get('card_number'));
    $cardSecurity = (int)preg_replace('/[^0-9]+/', '', $this->get('card_security_code'));
    $cardExpiration = preg_replace('/[^0-9\/]+/', '', $this->get('card_expiration_date'));

    if (!self::validateLuhn($cardNumber)) {
      $this->addContent('message', Translate::string('Card number is incorrect.'));
      $this->addContent('fields', ['card_number']);
      $this->finish(self::ERROR_CARD_INVALID, Status::OK);
    }

    $cardExpiration = explode('/', $cardExpiration);

    if (count($cardExpiration) !== 2) {
      $this->addContent('message', Translate::string('Card expiry date is incorrect.'));
      $this->addContent('fields', ['card_expiration_date']);
      $this->finish(self::ERROR_CARD_INVALID, Status::OK);
    }

    $currentYear = (int)date('y');

    // TODO: Validate if month is valid

    if ((int)$cardExpiration[0] > 12 || (int)$cardExpiration[0] < 1 || (int)$cardExpiration[1] < $currentYear || (int)$cardExpiration[1] > ($currentYear + 10)) {
      $this->addContent('message', Translate::string('Card expiry date is incorrect.'));
      $this->addContent('fields', ['card_expiration_date']);
      $this->finish(self::ERROR_CARD_INVALID, Status::OK);
    }

    if ($cardSecurity < 99 || $cardSecurity > 9999) {
      $this->addContent('message', Translate::string('Card expiry date is incorrect.'));
      $this->addContent('fields', ['card_security_code']);
      $this->finish(self::ERROR_CARD_INVALID, Status::OK);
    }

    $card = new Card();
    $card->number = $cardNumber;
    $card->holder = $cardHolder;
    $card->security = $cardSecurity;
    $card->expiration = $cardExpiration;

    if (CardRepository::cardExists($user, $card)) {
      $this->addContent('message', Translate::string('The given card has already been saved.'));
      $this->addContent('fields', ['card_number']);
      $this->finish(self::ERROR_INTERNAL_ERROR, Status::OK);
    }

    $savedCard = CardRepository::addUserCard($user, $card);

    if (empty($savedCard)) {
      $this->addContent('message', Translate::string('Something went wrong...'));
      $this->finish(self::ERROR_INTERNAL_ERROR, Status::OK);
    }

    $this->addContent('redirect', Redirect::url('dashboard/account'));
    $this->finish(self::CODE_SUCCESS, Status::OK);
  }

  /**
   * Luhn algorithm number checker
   * Copyright (c) 2005-2008 shaman - www.planzero.org
   * This code has been released into the public domain, however please give credit to the original author where possible.
   *
   * Modified by Leszek Pomianowski
   * Still CC0
   */
  private static function validateLuhn(string $cardNumber): bool
  {
    // Strip any non-digits (useful for credit card numbers with spaces and hyphens)
    $number = preg_replace('/D/', '', $cardNumber);

    // Set the string length and parity
    $numberLength = strlen($number);

    $parity = $numberLength % 2;

    // Loop through each digit and do the maths
    $total = 0;

    for ($i = 0; $i < $numberLength; $i++) {
      $digit = $number[$i];

      // Multiply alternate digits by two
      if ($i % 2 == $parity) {
        $digit *= 2;

        // If the sum is two digits, add them together (in effect)
        if ($digit > 9) {
          $digit -= 9;
        }
      }

      // Total up the digits
      $total += $digit;
    }

    // If the total mod 10 equals 0, the number is valid
    return $total % 10 == 0;
  }
}
