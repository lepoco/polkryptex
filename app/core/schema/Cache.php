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
  public function remember(string $key, \Closure $callback): mixed;

  public function put(string $key, mixed $value): bool;

  public function get(string $key): mixed;

  public function has(string $key): bool;
}
