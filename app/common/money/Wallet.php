<?php

namespace App\Common\Money;

use App\Common\Money\Currency;
use App\Core\Auth\User;

/**
 * Represents a wallet instance.
 *
 * @author  Pomianowski <kontakt@rapiddev.pl>
 * @license GPL-3.0 https://www.gnu.org/licenses/gpl-3.0.txt
 * @since   1.1.0
 */
final class Wallet extends \App\Core\Data\DatabaseObject
{
  private int $currencyId = 0;

  private int $userId = 0;

  private float $balance = 0;

  private string $createdAt = '';

  private string $updatedAt = '';

  private Currency $currency;

  private User $user;

  public function __construct(int $id = 0)
  {
    $this->currency = new Currency(0);
    $this->user = new User(0);

    if (0 === $id) {
      return;
    }

    $this->fetch($id);
  }

  public static function build(array $properties): self
  {
    return (new self())
      ->setId($properties['id'] ?? 0)
      ->setBalance($properties['balance'] ?? 0)
      ->setUserId($properties['user_id'] ?? 0)
      ->setCurrencyId($properties['currency_id'] ?? 0)
      ->setCreatedAt($properties['created_at'] ?? '')
      ->setUpdatedAt($properties['updated_at'] ?? '');
  }

  private function fetch(int $id): self
  {
    // TODO: Implement fetch
    return $this;
  }

  public function getBalance(): float
  {
    return $this->balance;
  }

  public function setBalance(float $balance): self
  {
    $this->balance = $balance;

    return $this;
  }

  public function getUser(): User
  {
    return $this->user;
  }

  public function getUserId(): int
  {
    return $this->userId;
  }

  public function setUserId(int $userId): self
  {
    if (0 < $userId) {
      $this->user = new User($userId);
    }

    $this->userId = $userId;

    return $this;
  }

  public function getCurrencyId(): int
  {
    return $this->currencyId;
  }

  public function setCurrencyId(int $currencyId): self
  {
    if (0 < $currencyId) {
      $this->currency = new Currency($currencyId);
    }

    $this->currencyId = $currencyId;

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
}
