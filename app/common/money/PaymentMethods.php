<?php

namespace App\Common\Money;

use App\Core\Facades\DB;

/**
 * Represents the available payment methods.
 *
 * @author  Pomianowski <kontakt@rapiddev.pl>
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
}
