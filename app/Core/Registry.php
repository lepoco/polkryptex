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
    private const OBJECT_KEY = 0;
    private const ACCESS_KEY = 1;

    private static array $objects = [];

    public static function dump(): array
    {
        return defined('POLKRYPTEX_DEBUG') && POLKRYPTEX_DEBUG ? self::$objects : [];
    }

    public static function register(string $name, $object, array $access = []): void
    {
        self::$objects[$name] = [$object, $access];
    }

    public static function get(string $name): ?object
    {
        // if (!empty(self::$objects[$name][self::ACCESS_KEY]) && !in_array(self::getCallingClass(), self::$objects[$name][self::ACCESS_KEY])) {
        //     throw new \LogicException('Insufficient class permissions to a get aregistry object');
        // }

        return self::$objects[$name][self::OBJECT_KEY] ?? null;
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
