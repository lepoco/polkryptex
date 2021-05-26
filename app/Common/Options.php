<?php

/**
 * @package   Polkryptex
 *
 * @copyright Copyright (c) 2021 - Kacper J., Pawel L., Filip S., Szymon K., Leszek P.
 * @license   https://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace Polkryptex\Common;

use Polkryptex\Core\Registry;

/**
 * @author Leszek P.
 */
final class Options
{
    protected array $cache = [];

    public function get(string $name)
    {
        if(in_array($name, $this->cache))
        {
            return $this->cache[$name];
        }

        $database = Registry::get('Database');

        if(!$database->isConnected())
        {
            return null;
        }
    }

    public function update(string $name, $value): void
    {
        $this->cache[$name] = $value;
    }
}
