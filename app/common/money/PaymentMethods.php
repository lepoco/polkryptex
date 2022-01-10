<?php

namespace App\Common\Money;

use App\Core\Facades\Translate;

/**
 * Represents the available payment methods.
 *
 * @author  Pomianowski <support@polkryptex.pl>
 * @license GPL-3.0 https://www.gnu.org/licenses/gpl-3.0.txt
 * @since   1.1.0
 */
final class PaymentMethods
{
  public const UNKNOWN = '';

  public const INTERNAL = 'internal';

  public const APPLE_PAY = 'apple_pay';

  public const GOOGLE_PAY = 'google_pay';

  public const PAYPAL = 'paypal';

  public const CARD = 'card';

  public const TRANSFER = 'bank_transfer';

  public const BLIK = 'blik';

  public const PRZELEWY_24 = 'przelewy_24';

  public const IMOJE = 'imoje';

  public static function getName(string $name): string
  {
    switch ($name) {
      case self::INTERNAL:
        return Translate::string('Transfer');

      case self::APPLE_PAY:
        return Translate::string('Apple Pay');

      case self::GOOGLE_PAY:
        return Translate::string('Google Pay');

      case self::PAYPAL:
        return Translate::string('PayPal');

      case self::CARD:
        return Translate::string('Credit Card');

      case self::TRANSFER:
        return Translate::string('Bank Transfer');

      case self::PRZELEWY_24:
        return Translate::string('Przelewy 24');

      case self::IMOJE:
        return Translate::string('iMoje');

      default:
        return Translate::string('Other method');
    }
  }
}
