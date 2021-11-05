<?php

namespace App\Core\Cache;

/**
 * Responsible for storing information in the Redis database.
 *
 * @author  Pomianowski <kontakt@rapiddev.pl>
 * @license GPL-3.0 https://www.gnu.org/licenses/gpl-3.0.txt
 * @since   1.1.0
 */
final class Redis implements \App\Core\Schema\Cache
{
  // TODO: Implement redis

  public function remember(string $key, \Closure $callback): mixed
  {
    return false;
  }

  public function put(string $key, mixed $value): bool
  {
    return false;
  }

  public function get(string $key): mixed
  {
    return false;
  }

  public function has(string $key): bool
  {
    return false;
  }
}
