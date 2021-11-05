<?php

namespace App\Common\Money;

use App\Common\Money\Wallet;
use App\Core\Auth\User;

/**
 * Represents a single transaction.
 *
 * @author  Pomianowski <kontakt@rapiddev.pl>
 * @license GPL-3.0 https://www.gnu.org/licenses/gpl-3.0.txt
 * @since   1.1.0
 */
final class Transaction extends \App\Core\Data\DatabaseObject
{
  private int $userId = 0;

  private int $walletFromId = 0;

  private int $walletToId = 0;

  private float $amount = 0;

  private bool $topup = false;

  private string $uuid = '';

  private string $createdAt = '';

  private User $user;

  private Wallet $walletFrom;

  private Wallet $walletTo;

  public function __construct(int $id = 0)
  {
    $this->user = new User(0);
    $this->walletFrom = new Wallet(0);
    $this->walletTo = new Wallet(0);

    if (0 === $id) {
      return;
    }

    $this->fetch($id);
  }

  public static function build(array $properties): self
  {
    return (new self())
      ->setUserId($properties['user_id'] ?? 0)
      ->setWalletFromId($properties['wallet_from'] ?? 0)
      ->setWalletToId($properties['wallet_to'] ?? '')
      ->setAmount($properties['amount'] ?? 0)
      ->setUUID($properties['uuid'] ?? '')
      ->defineTopup($properties['is_topup'] ?? false)
      ->setCreatedAt($properties['updated_at'] ?? date('Y-m-d H:i:s'))
      ->setId($properties['id'] ?? 0);
  }

  private function fetch(int $id): void
  {
    // TODO: Implement fetch
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

  public function getWalletFrom(): Wallet
  {
    return $this->walletFrom;
  }

  public function getWalletFromId(): int
  {
    return $this->walletFromId;
  }

  public function setWalletFromId(int $walletFromId): self
  {
    if (0 < $walletFromId) {
      $this->walletFrom = new Wallet($walletFromId);
    }

    $this->walletFromId = $walletFromId;

    return $this;
  }

  public function getWalletTo(): Wallet
  {
    return $this->walletTo;
  }

  public function getWalletToId(): int
  {
    return $this->walletToId;
  }

  public function setWalletToId(int $walletToId): self
  {
    if (0 < $walletToId) {
      $this->walletTo = new Wallet($walletToId);
    }

    $this->walletToId = $walletToId;

    return $this;
  }

  public function getAmount(): float
  {
    return $this->amount;
  }

  private function setAmount(float $amount): self
  {
    $this->amount = $amount;

    return $this;
  }

  public function getUUID(): string
  {
    return $this->uuid;
  }

  private function setUUID(string $uuid): self
  {
    $this->uuid = $uuid;

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

  public function isTopup(): bool
  {
    return $this->topup;
  }

  private function defineTopup(bool $isTopup): self
  {
    $this->topup = $isTopup;

    return $this;
  }
}
