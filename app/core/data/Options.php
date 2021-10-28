<?php

namespace App\Core\Data;

use App\Core\Facades\{App, DB};

/**
 * Allows to retrieve and save options from the database, stored in memory using the Cache.
 *
 * @author  Pomianowski <kontakt@rapiddev.pl>
 * @license GPL-3.0 https://www.gnu.org/licenses/gpl-3.0.txt
 * @since   1.1.0
 */
final class Options
{
  private array $store = [];

  public function remember(string $name, \Closure $callback): mixed
  {
    if (isset($this->store[$name])) {
      return $this->store[$name];
    }

    if (!App::isConnected()) {
      $this->store[$name] = $callback();

      return $this->store[$name];
    }

    $query = DB::table('options')->where('name', $name)->first();

    $this->store[$name] = isset($query->value) ? self::serializeType($query->value) : $callback();

    return $this->store[$name];
  }

  public function get(string $name, mixed $default = null): mixed
  {
    if (isset($this->store[$name])) {
      return $this->store[$name];
    }

    if (!App::isConnected()) {
      return $default;
    }

    $query = DB::table('options')->where('name', $name)->first();

    if (isset($query->value)) {
      $this->store[$name] = self::serializeType($query->value);

      return self::serializeType($query->value);
    }

    return $default;
  }

  public function set(string $name, $value): bool
  {
    $this->store[$name] = $value;

    if (!App::isConnected()) {
      return false;
    }

    return DB::table('options')->where('name', $name)->update([
      'value' => $value
    ]);
  }

  private static function serializeType(mixed $value): mixed
  {
    return $value;
  }
}
