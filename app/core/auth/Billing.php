<?php

namespace App\Core\Auth;

class Billing
{
  /**
   * Create a billing instance from an associative array.
   */
  public static function build(array $properties): self
  {
    return (new self());
  }
}
