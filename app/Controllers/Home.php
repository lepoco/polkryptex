<?php

/**
 * @package   Polkryptex
 *
 * @copyright Copyright (c) 2021 - Kacper J., Pawel L., Filip S., Szymon K., Leszek P.
 * @license   https://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace Polkryptex\Controllers;

use Polkryptex\Core\Singleton as App;

/**
 * @author Leszek P.
 */
final class Home extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->print();
    }

    protected function testDebugPrint(): void
    {
        App::get()->debug->warning('Opened page: ' . $this->name);

        dump($this);
        dump(App::get());
    }
}
