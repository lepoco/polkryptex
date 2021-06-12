<?php

/**
 * @package   Polkryptex
 *
 * @copyright Copyright (c) 2021 - Kacper J., Pawel L., Filip S., Szymon K., Leszek P.
 * @license   https://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace Polkryptex\Common\Controllers;

use Polkryptex\Core\Controller;

/**
 * @author Leszek P.
 */
final class Installer extends Controller
{
    public function init()
    {
        $this->setTitle('Installer');
        $this->setAsFullScreen();
        
        $this->queueInternalScript('pages/install');
    }
}
