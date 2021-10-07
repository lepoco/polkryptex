<?php

namespace App\Core\Auth;

use App\Core\Utils\Cast;
use App\Core\Facades\DB;
use App\Core\Data\Encryption;

final class Billing
{
  private int $id = 0;

  private string $firstName = '';

  private string $lastName = '';

  private string $street = '';

  private string $postal = '';

  private string $city = '';

  private string $country = '';

  private string $province = '';

  private string $phone = '';

  private string $email = '';

  private string $timezone = '';

  private string $updatedAt = '';

  public function __construct(int $id = 0)
  {
    $this->fetch($id);
  }

  /**
   * Create a billing instance from an associative array.
   */
  public static function build(array $properties): self
  {
    return (new self());
  }

  private function fetch(int $id): bool
  {
    if (0 === $id) {
      return false;
    }

    $data = DB::table('user_billings')->where('id', $id)->first();

    if (empty($data)) {
      return false;
    }

    return true;
  }
}
