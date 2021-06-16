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
    protected static array $cache = [];

    public static function get(string $name, $default = null)
    {
        if (in_array($name, self::$cache)) {
            return self::$cache[$name];
        }

        $query = self::getDatabase($name);
        if (empty($query)) {
            return $default;
        }
        self::$cache[$name] = $query['option_value'];

        return $query['option_value'];
    }

    public static function update(string $name, $value)
    {
        if (self::updateDatabase($name, $value)) {
            self::$cache[$name] = $value;
        }
    }

    private static function getDatabase(string $name)
    {
        $database = Registry::get('Database');
        if (!$database->isConnected()) {
            return null;
        }

        return $database->query("SELECT option_value FROM pkx_options WHERE option_name = ?", $name)->fetchArray(); //fetchAll
    }

    private static function updateDatabase(string $name, $value): bool
    {
        $database = Registry::get('Database');
        if (!$database->isConnected()) {
            return false;
        }

        if (empty(self::getDatabase($name))) {
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
