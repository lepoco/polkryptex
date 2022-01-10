<?php

namespace App\Common\Money;

use App\Core\Facades\DB;

/**
 * Represents a currency instance.
 *
 * @author  Pomianowski <support@polkryptex.pl>
 * @license GPL-3.0 https://www.gnu.org/licenses/gpl-3.0.txt
 * @since   1.1.0
 */
final class Currency extends \App\Core\Data\DatabaseObject
{
  private bool $master = false;

  private bool $crypto = false;

  private bool $signLeft = true;

  private float $rate = 0;

  private int $isoNumber = 0;

  private string $isoCode = '';

  private string $sign = '';

  private string $name = '';

  private string $subunitSign = '';

  private string $subunitName = '';

  private int $subunitMultiplier = 100;

  private string $createdAt = '';

  private string $updatedAt = '';

  public function __construct(int $id = 0)
  {
    $this->id = $id;

    $this->fetch($id);
  }

  public static function build(array $properties): self
  {
    return (new self())
      ->setRate($properties['rate'] ?? 0)
      ->setIsoNumber($properties['iso_number'] ?? 0)
      ->setIsoCode($properties['iso_code'] ?? '')
      ->setSign($properties['sign'] ?? '')
      ->setName($properties['name'] ?? '')
      ->setSubunitSign($properties['subunit_sign'] ?? '')
      ->setSubunitName($properties['subunit_name'] ?? '')
      ->setSubunitMultiplier($properties['subunit_multiplier'] ?? 100)
      ->setCreatedAt($properties['created_at'] ?? date('Y-m-d H:i:s'))
      ->setUpdatedAt($properties['updated_at'] ?? date('Y-m-d H:i:s'))
      ->defineCrypto($properties['is_crypto'] ?? false)
      ->defineMaster($properties['is_master'] ?? false)
      ->defineSignLeft($properties['sign_left'] ?? true)
      ->setId($properties['id'] ?? 0);
  }

  public function updateRate(float $rate): bool
  {
    if ($this->getId() < 1) {
      return false;
    }

    return DB::table('currencies')->where('id', $this->getId())->update([
      'rate' => $rate,
      'updated_at' => date('Y-m-d H:i:s')
    ]);
  }

  private function fetch(int $id): void
  {
    if (0 === $id) {
      return;
    }

    $dbCurrency = DB::table('currencies')->where(['id' => $id])->get()->first();

    if (!isset($dbCurrency->id) || !isset($dbCurrency->rate)) {
      return;
    }

    $this->id = $dbCurrency->id;
    $this->rate = $dbCurrency->rate;
    $this->isoNumber = $dbCurrency->iso_number;
    $this->isoCode = $dbCurrency->iso_code;
    $this->sign = $dbCurrency->sign;
    $this->name = $dbCurrency->name;
    $this->signLeft = $dbCurrency->sign_left;
    $this->subunitSign = $dbCurrency->subunit_sign;
    $this->subunitName = $dbCurrency->subunit_name;
    $this->subunitMultiplier = $dbCurrency->subunit_multiplier;
    $this->createdAt = $dbCurrency->created_at;
    $this->updatedAt = $dbCurrency->updated_at;
    $this->master = $dbCurrency->is_master;
    $this->crypto = $dbCurrency->is_crypto;
  }

  public function getRate(): float
  {
    return $this->rate;
  }

  public function setRate(float $rate): self
  {
    $this->rate = $rate;

    return $this;
  }

  public function getIsoNumber(): int
  {
    return $this->isoNumber;
  }

  public function setIsoNumber(int $isoNumber): self
  {
    $this->isoNumber = $isoNumber;

    return $this;
  }

  public function getIsoCode(): string
  {
    return $this->isoCode;
  }

  public function setIsoCode(string $isoCode): self
  {
    $this->isoCode = $isoCode;

    return $this;
  }

  public function getSign(): string
  {
    return $this->sign;
  }

  public function setSign(string $sign): self
  {
    $this->sign = $sign;

    return $this;
  }

  public function getName(): string
  {
    return $this->name;
  }

  public function setName(string $name): self
  {
    $this->name = $name;

    return $this;
  }

  public function getSubunitSign(): string
  {
    return $this->subunitSign;
  }

  public function setSubunitSign(string $subunitSign): self
  {
    $this->subunitSign = $subunitSign;

    return $this;
  }

  public function getSubunitName(): string
  {
    return $this->subunitName;
  }

  public function setSubunitName(string $subunitName): self
  {
    $this->subunitName = $subunitName;

    return $this;
  }

  public function getSubunitMultiplier(): int
  {
    return $this->subunitMultiplier;
  }

  public function setSubunitMultiplier(int $subunitMultiplier): self
  {
    $this->subunitMultiplier = $subunitMultiplier;

    return $this;
  }

  public function getCreatedAt(): string
  {
    return $this->createdAt;
  }

  private function setCreatedAt(string $createdAt): self
  {
    $this->createdAt = $createdAt;

    return $this;
  }

  public function getUpdatedAt(): string
  {
    return $this->updatedAt;
  }

  private function setUpdatedAt(string $updatedAt): self
  {
    $this->updatedAt = $updatedAt;

    return $this;
  }

  public function isMaster(): bool
  {
    return $this->master;
  }

  public function isSignLeft(): bool
  {
    return $this->signLeft;
  }

  public function isCrypto(): bool
  {
    return $this->crypto;
  }

  public function defineSignLeft(bool $signLeft): self
  {
    $this->signLeft = $signLeft;

    return $this;
  }

  private function defineCrypto(bool $crypto): self
  {
    $this->crypto = $crypto;

    return $this;
  }

  private function defineMaster(bool $master): self
  {
    $this->master = $master;

    return $this;
  }
}
