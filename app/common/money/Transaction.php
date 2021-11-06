<?php

namespace App\Common\Money;

use App\Common\Money\Wallet;
use App\Core\Auth\User;
use App\Core\Facades\DB;

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

  private int $methodId = 1;

  private int $typeId = 1;

  private float $amount = 0;

  private float $rate = 1;

  private bool $topup = false;

  private string $uuid = '';

  private string $methodReference = '';

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
      ->setMethodReference($properties['method_reference'] ?? '')
      ->setMethodId($properties['method_id'] ?? 1)
      ->setTypeId($properties['type_id'] ?? 1)
      ->setRate($properties['rate'] ?? 1)
      ->setUUID($properties['uuid'] ?? '')
      ->defineTopup($properties['is_topup'] ?? false)
      ->setCreatedAt($properties['created_at'] ?? date('Y-m-d H:i:s'))
      ->setId($properties['id'] ?? 0);
  }

  private function fetch(int $id): void
  {
    $dbTransaction = DB::table('transactions')->where(['id' => $id])->get()->first();

    if (!isset($dbTransaction->id) || !isset($dbTransaction->user_id)) {
      return;
    }

    $this->id = $dbTransaction->id;
    $this->amount = $dbTransaction->amount ?? 0;
    $this->rate = $dbTransaction->rate ?? 1;
    $this->topup = $dbTransaction->is_topup ?? false;
    $this->uuid = $dbTransaction->uuid ?? '';
    $this->methodReference = $dbTransaction->method_reference ?? '';
    $this->methodId = $dbTransaction->method_id ?? 1;
    $this->typeId = $dbTransaction->type_id ?? 1;
    $this->createdAt = $dbTransaction->created_at ?? date('Y-m-d H:i:s');

    $this->setUserId($dbTransaction->user_id ?? 0);
    $this->setWalletFromId($dbTransaction->wallet_from ?? 0);
    $this->setWalletToId($dbTransaction->wallet_to ?? 0);
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
    if (0 !== $walletFromId) {
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
    if (0 !== $walletToId) {
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

  public function getRate(): float
  {
    return $this->rate;
  }

  private function setRate(float $rate): self
  {
    $this->rate = $rate;

    return $this;
  }

  public function getMethodReference(): string
  {
    return $this->methodReference;
  }

  private function setMethodReference(string $methodReference): self
  {
    $this->methodReference = $methodReference;

    return $this;
  }

  public function getMethodId(): int
  {
    return $this->methodId;
  }

  private function setMethodId(string $methodId): self
  {
    $this->methodId = $methodId;

    return $this;
  }

  public function getTypeId(): int
  {
    return $this->typeId;
  }

  private function setTypeId(string $typeId): self
  {
    $this->typeId = $typeId;

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
