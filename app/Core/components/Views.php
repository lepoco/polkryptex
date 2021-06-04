<?php

/**
 * @package   Polkryptex
 *
 * @copyright Copyright (c) 2021 - Kacper J., Pawel L., Filip S., Szymon K., Leszek P.
 * @license   https://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace Polkryptex\Core\Components;

/**
 * @author Leszek P.
 */
final class Views
{
    public static function display(string $name)
    {
        \Polkryptex\Core\Registry::get('Variables')->set('page_now', $name);

        $controller = 'Polkryptex\\Common\\Controllers\\' . $name;
        if (!class_exists($controller)) {
            return new \Polkryptex\Core\Controller($name);
        }

        return new $controller($name);
    }
}
