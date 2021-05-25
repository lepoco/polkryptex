<?php

/**
 * @package   Polkryptex
 *
 * @copyright Copyright (c) 2021 - Kacper J., Pawel L., Filip S., Szymon K., Leszek P.
 * @license   https://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace Polkryptex\Controllers;

use Polkryptex\Core\Singleton;

class Controller
{
    protected ?string $name;

    public function __construct()
    {
        $this->name = Singleton::get()->variables->get('pagenow');

        if(get_parent_class($this) == null)
        {
            $this->print();
        }
    }

    protected function getComponent(string $name)
    {
        if (is_file(ABSPATH . APPDIR . 'views/components/' . $name . '.php')) {
            require_once ABSPATH . APPDIR . 'views/components/' . $name . '.php';
        } else {
            echo 'Component not found!';
        }
    }

    protected function print(): void
    {
        if (is_file(ABSPATH . APPDIR . 'views/' . $this->name . '.php')) {
            require_once ABSPATH . APPDIR . 'views/' . $this->name . '.php';
        } else {
            Singleton::get()->debug->error('Page not found - ' . $this->name);
        }


        exit;
    }
}
