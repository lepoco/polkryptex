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
//antipattern, really?
//https://stackoverflow.com/questions/37733391/singleton-alternative-for-php-pdo
//http://fabien.potencier.org/what-is-dependency-injection.html
//https://www.reddit.com/r/PHP/comments/1vfqm0/singleton_alternative/
final class Singleton
{
    private static Application $instance;

    public static function get(): Application
    {
        if (!static::$instance) {
            throw new \LogicException("The Application object isn't initialized yet");
        }

        return static::$instance;
    }

    public static function set(Application $instance)
    {
        static::$instance = $instance;
    }
}
