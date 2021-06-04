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
final class Views
{
    public static function display(string $name)
    {
        Registry::get('Variables')->set('page_now', $name);

        $controller = 'Polkryptex\\Common\\Controllers\\' . $name;
        if (!class_exists($controller)) {
            return new Controller($name);
        }

        return new $controller($name);
    }
}
