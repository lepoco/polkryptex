<?php

namespace App\Common\Money;

use App\Core\Facades\DB;

/**
 * Represents a credit card instance.
 *
 * @author  Pomianowski <kontakt@rapiddev.pl>
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
    return !empty($this->holder) && !empty($this->number) && !empty($this->expiration) && !empty($this->security);
  }
}
