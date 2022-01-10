<?php

namespace App\Common\Money;

use App\Core\Facades\DB;

/**
 * Represents a credit card instance.
 *
 * @author  Pomianowski <support@polkryptex.pl>
 * @license GPL-3.0 https://www.gnu.org/licenses/gpl-3.0.txt
 * @since   1.1.0
 */
final class Card
{
  public string $holder;

  public string $number;

  public array $expiration;

  public int $security;

  public function isValid(): bool
  {
    if (!isset($this->holder) || !isset($this->number) || !isset($this->expiration) || !isset($this->security)) {
      return false;
    }

    if (empty($this->holder) || empty($this->number) || empty($this->expiration) || empty($this->security)) {
      return false;
    }

    return true;
  }

  public function getProvider(): string
  {
    if (!$this->isValid()) {
      return '';
    }

    $providers = [
      'electron' =>     "/^(4026|417500|4405|4508|4844|4913|4917)\d+$/",
      'maestro' =>      "/^(5018|5020|5038|5612|5893|6304|6759|6761|6762|6763|0604|6390)\d+$/",
      'dankort' =>      "/^(5019)\d+$/",
      'interpayment' => "/^(636)\d+$/",
      'unionpay' =>     "/^(62|88)\d+$/",
      'visa' =>         "/^4[0-9]{12}(?:[0-9]{3})?$/",
      'mastercard' =>   "/^5[1-5][0-9]{14}$'/",
      'amex' =>         "/^3[47][0-9]{13}$/",
      'diners' =>       "/^3(?:0[0-5]|[68][0-9])[0-9]{11}$/",
      'discover' =>     "/^6(?:011|5[0-9]{2})[0-9]{12}$/",
      'jcb' =>          "/^(?:2131|1800|35\d{3})\d{11}$/"
    ];

    foreach ($providers as $providerName => $pattern) {
      if (1 === preg_match($pattern, $this->number)) {
        return $providerName;
      }
    }

    return '';
  }
}
