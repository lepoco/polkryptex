<?php

/**
 * @package   Polkryptex
 *
 * @copyright Copyright (c) 2021 - Kacper J., Pawel L., Filip S., Szymon K., Leszek P.
 * @license   https://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace Polkryptex\Core;

/**
 * @author Leszek P.
 */
final class Registry
{
    private static array $objects = [];

    public static function &dump(): array
    {
        return defined('POLKRYPTEX_DEBUG') && POLKRYPTEX_DEBUG ? self::$objects : [];
    }

    public static function register(string $name, $object, array $access = []): void
    {
        self::$objects[$name] = [$object, $access];
    }

    public static function &get(string $name)
    {
        if (!empty(self::$objects[$name][1]) && !in_array(self::getCallingClass(), self::$objects[$name][1])) {
            throw new \LogicException('Insufficient class permissions to a registry object');
        }

        return self::$objects[$name][0] ?? null;
    }

    private static function getCallingClass()
    {
        $trace = debug_backtrace();
        $class = $trace[1]['class'];

        for ($i = 1; $i < count($trace); $i++) {
            if (isset($trace[$i]) && $class != $trace[$i]['class']) {
                return $trace[$i]['class'];
            }
        }
    }
}
