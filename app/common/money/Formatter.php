<?php

namespace App\Common\Money;

/**
 * Formats money strings.
 *
 * @author  Pomianowski <support@polkryptex.pl>
 * @license GPL-3.0 https://www.gnu.org/licenses/gpl-3.0.txt
 * @since   1.1.0
 */
final class Formatter
{
  public static function toString(float $amount): string
  {
    $number = number_format($amount, 12, '.', ' ');
    $number = rtrim($number, '0');

    if (str_ends_with($number, '.')) {
      $number .= '00';
    }

    return $number;
  }
}
