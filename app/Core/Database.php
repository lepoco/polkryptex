<?php

/**
 * @package   Polkryptex
 *
 * @copyright Copyright (c) 2021 - Kacper J., Pawel L., Filip S., Szymon K., Leszek P.
 * @license   https://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace Polkryptex\Core;

use Nette\Database\Connection;
use Polkryptex\Core\Singleton as App;

/**
 * @author Leszek P.
 */
final class Database
{
    public Connection $connection;

    public function __construct()
    {
        if (App::get()->variables->get('version') == null) {
            return;
        }

        //$this->connection = new Connection(POLKRYPTEX_DB_HOST, POLKRYPTEX_DB_USER, POLKRYPTEX_DB_PASS);
    }
}
