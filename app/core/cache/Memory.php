<?php

namespace App\Core\Cache;

/**
 * Cache that stores data in memory as an array.
 *
 * @author  Pomianowski <kontakt@rapiddev.pl>
 * @license GPL-3.0 https://www.gnu.org/licenses/gpl-3.0.txt
 * @since   1.1.0
 */
class Memory implements \App\Core\Schema\Cache
{
  protected array $records = [];

  public function remember(string $key, \Closure $callback): mixed
  {
    // TODO: REMEMBER SHOULD HAVE TIMEOUT

    if ($this->has($key)) {
      return $this->get($key, null);
    }

    $return = $callback();

    $this->put($key, $return);

    return $return;
  }

  public function put(string $key, mixed $value): bool
  {
    return $this->memoryPut($key, $value);
  }

  public function get(string $key, mixed $default): mixed
  {
    return $this->memoryGet($key, $default);
  }

  public function has(string $key): bool
  {
    return $this->memoryHas($key);
  }

  public function flush(): bool
  {
    return $this->flushMemory();
  }

  public function forget(string $key): bool
  {
    return $this->forgetFromMemory($key);
  }

  final protected function flushMemory(): bool
  {
    $this->records = [];

    return true;
  }

  final protected function forgetFromMemory(string $key): bool
  {
    $keyArray = explode('.', $key);
    $keyCount = count($keyArray);

    if (1 === $keyCount && isset($this->records[$keyArray[0]])) {
      unset($this->records[$keyArray[0]]);

      return true;
    }

    if (2 === $keyCount && isset($this->records[$keyArray[0]][$keyArray[1]])) {
      unset($this->records[$keyArray[0]][$keyArray[1]]);

      return true;
    }

    if (3 === $keyCount && isset($this->records[$keyArray[0]][$keyArray[1]][$keyArray[2]])) {
      unset($this->records[$keyArray[0]][$keyArray[1]][$keyArray[2]]);

      return true;
    }

    if (4 === $keyCount && isset($this->records[$keyArray[0]][$keyArray[1]][$keyArray[2]][$keyArray[3]])) {
      unset($this->records[$keyArray[0]][$keyArray[1]][$keyArray[2]][$keyArray[3]]);

      return true;
    }

    return false;
  }

  final protected function memoryHas(string $key): bool
  {
    $keyArray = explode('.', $key);
    $keyCount = count($keyArray);

    if (1 === $keyCount) {
      return isset($this->records[$keyArray[0]]);
    }

    if (2 === $keyCount) {
      return isset($this->records[$keyArray[0]][$keyArray[1]]);
    }

    if (3 === $keyCount) {
      return isset($this->records[$keyArray[0]][$keyArray[1]][$keyArray[2]]);
    }

    if (4 === $keyCount) {
      return isset($this->records[$keyArray[0]][$keyArray[1]][$keyArray[2]][$keyArray[3]]);
    }

    return false;
  }

  final protected function memoryGet(string $key, mixed $default): mixed
  {
    if (!$this->memoryHas($key)) {
      return $default;
    }

    $keyArray = explode('.', $key);
    $keyCount = count($keyArray);

    if (1 === $keyCount) {
      return $this->records[$keyArray[0]];
    }

    if (2 === $keyCount) {
      return $this->records[$keyArray[0]][$keyArray[1]];
    }

    if (3 === $keyCount) {
      return $this->records[$keyArray[0]][$keyArray[1]][$keyArray[2]];
    }

    if (4 === $keyCount) {
      return $this->records[$keyArray[0]][$keyArray[1]][$keyArray[2]][$keyArray[3]];
    }

    return $default;
  }

  final protected function memoryPut(string $key, mixed $value): bool
  {
    $keyArray = explode('.', $key);
    $keyCount = count($keyArray);

    if (1 === $keyCount) {
      $this->records[$keyArray[0]] = $value;

      return true;
    }

    if (2 === $keyCount) {
      $this->records[$keyArray[0]][$keyArray[1]] = $value;

      return true;
    }

    if (3 === $keyCount) {
      $this->records[$keyArray[0]][$keyArray[1]][$keyArray[2]] = $value;

      return true;
    }

    if (4 === $keyCount) {
      $this->records[$keyArray[0]][$keyArray[1]][$keyArray[2]][$keyArray[3]] = $value;

      return true;
    }

    return false;
  }
}
