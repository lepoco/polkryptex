<?php

/**
 * @package   Polkryptex
 *
 * @copyright Copyright (c) 2021 - Kacper J., Pawel L., Filip S., Szymon K., Leszek P.
 * @license   https://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace Polkryptex\Common;

/**
 * @author Leszek P.
 */
final class Variables
{
    protected array $variables = [];

    public function __construct()
    {
        $this->set('debug', (defined('POLKRYPTEX_DEBUG') && POLKRYPTEX_DEBUG));
        $this->set('debug_display', (defined('POLKRYPTEX_DEBUG_DISPLAY') && POLKRYPTEX_DEBUG_DISPLAY));
        $this->set('version', (defined('POLKRYPTEX_VERSION') && POLKRYPTEX_VERSION ? POLKRYPTEX_VERSION : ''));
    }

    public function set(string $name, $value): void
    {
        if (!isset($this->variables[$name])) {
            $this->variables[$name] = $value;
        }
    }

    public function get(string $name)
    {
        if (isset($this->variables[$name])) {
            return $this->variables[$name];
        } else {
            return null;
        }
    }
}
