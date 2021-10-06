<?php

namespace App\Core\Auth;

class Billing
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

  /**
   * Create a billing instance from an associative array.
   */
  public static function build(array $properties): self
  {
    return (new self());
  }
}
