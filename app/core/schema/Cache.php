<?php

namespace App\Core\Schema;

/**
 * Base interface for Cache.
 *
 * @author  Pomianowski <kontakt@rapiddev.pl>
 * @license GPL-3.0 https://www.gnu.org/licenses/gpl-3.0.txt
 * @since   1.1.0
 */
interface Cache
{
  /**
   * Get an item from the cache, or execute the given Closure and store the result.
   */
  public function remember(string $key, \Closure $callback): mixed;

  /**
   * Store an item in the cache for a given number of seconds.
   */
  public function put(string $key, mixed $value): bool;

  /**
   * Retrieve an item from the cache by key.
   */
  public function get(string $key, mixed $default): mixed;

  /**
   * Check if the item exists in the cache.
   */
  public function has(string $key): bool;

  /**
   *  Remove an item from the cache.
   */
  public function forget(string $key): bool;
  /**
   * Remove all items from the cache.
   */
  public function flush(): bool;
}
