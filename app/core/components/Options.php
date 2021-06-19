<?php

/**
 * @package   Polkryptex
 *
 * @copyright Copyright (c) 2021 - Kacper J., Pawel L., Filip S., Szymon K., Leszek P.
 * @license   https://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace Polkryptex\Core\Components;

use Polkryptex\Core\Registry;

/**
 * @author Leszek P.
 */
final class Options
{
    protected array $cache = [];

    public function get(string $name, $default = null)
    {
        if (in_array($name, $this->cache)) {
            return $this->cache[$name];
        }

        $query = $this->getFromDatabase($name);
        if (empty($query)) {
            return $default;
        }
        $this->cache[$name] = $query['option_value'];

        return $query['option_value'];
    }

    public function update(string $name, $value)
    {
        if ($this->updateDatabase($name, $value)) {
            $this->cache[$name] = $value;
        }
    }

    private function getFromDatabase(string $name)
    {
        $database = Registry::get('Database');
        if (!$database->isConnected()) {
            return null;
        }

        return $database->query("SELECT option_value FROM pkx_options WHERE option_name = ?", $name)->fetchArray(); //fetchAll
    }

    private function updateDatabase(string $name, $value): bool
    {
        $database = Registry::get('Database');
        if (!$database->isConnected()) {
            return false;
        }

        if (empty($this->getFromDatabase($name))) {
            $query = $database->query("INSERT INTO pkx_options (option_name, option_value) VALUES (?,?)", $name, self::serializeType($value));
        } else {
            $query = $database->query("UPDATE pkx_options SET option_value = ? WHERE option_name = ?", self::serializeType($value), $name);
        }

        return $query->affectedRows() > 0 ? true : false;
    }

    private static function serializeType($option)
    {
        if ($option === true) {
            return 'true';
        } else if ($option === false) {
            return 'false';
        } else {
            return $option;
        }
    }
}
