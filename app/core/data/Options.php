<?php

namespace App\Core\Data;

use App\Core\Facades\{App, DB, Cache};

/**
 * Allows to retrieve and save options from the database, stored in memory using the Cache.
 *
 * @author  Pomianowski <kontakt@rapiddev.pl>
 * @license GPL-3.0 https://www.gnu.org/licenses/gpl-3.0.txt
 * @since   1.1.0
 */
final class Options
{
  private string $prefix = 'option_';

  public function setPrefix($prefix): void
  {
    $this->prefix = $prefix;
  }

  public function get(string $name, $default = '')
  {
    return Cache::remember($this->prefix . $name, 60, fn () => $this->getOption($name, $default));
  }

  public function set(string $name, $value): bool
  {
    return $this->setOption($name, $value);
  }

  private function getOption(string $name, $default = '')
  {
    if (!App::isConnected()) {
      return $default;
    }

    $query = DB::table('options')->where('name', 'LIKE', $name)->first();

    return isset($query->value) ? self::serializeType($query->value) : $default;
  }

  private function setOption(string $name, $value): bool
  {
    Cache::forget($name);

    return true;
  }

  private static function serializeType(mixed $value): mixed
  {
    return $value;
  }
}
