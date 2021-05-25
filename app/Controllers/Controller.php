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
    }
}
