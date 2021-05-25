<?php

/**
 * @package   Polkryptex
 *
 * @copyright Copyright (c) 2021 - Kacper J., Pawel L., Filip S., Szymon K., Leszek P.
 * @license   https://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace Polkryptex\Core;

final class Singleton
{
    /** @var Application */
    private static $app;

    /**
     * Wrong.
     *
     * @return Application
     */
    public static function get()
    {
        if (!static::$app) {
            throw new \LogicException("The Application object isn't initialized yet");
        }

        return static::$app;
    }

    public static function set(Application $app)
    {
        static::$app = $app;
    }
}
