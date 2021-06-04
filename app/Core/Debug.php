<?php

/**
 * @package   Polkryptex
 *
 * @copyright Copyright (c) 2021 - Kacper J., Pawel L., Filip S., Szymon K., Leszek P.
 * @license   https://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace Polkryptex\Core;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

/**
 * @author Leszek P.
 */
final class Debug
{
    private ?Logger $monolog = null;

    public function __construct()
    {
        if (defined('POLKRYPTEX_DEBUG') && POLKRYPTEX_DEBUG) {

            if (defined('POLKRYPTEX_DEBUG_DISPLAY') && POLKRYPTEX_DEBUG_DISPLAY) {
                ini_set('display_errors', 1);
                ini_set('display_startup_errors', 1);
                error_reporting(E_ALL);
            } else {
                error_reporting(0);
            }

            $this->monolog = new Logger('Polkryptex');
            $this->monolog->pushHandler(new StreamHandler(ABSPATH . APPDIR . 'error.log', Logger::WARNING));
        }
    }

    public function error(string $message): void
    {
        if ($this->monolog != null) {
            $this->monolog->error($message);
        }
    }

    public function warning(string $message): void
    {
        if ($this->monolog != null) {
            $this->monolog->warning($message);
        }
    }

    public function exception(string $message): void
    {
        $this->error('EXCEPTION: ' . $message);
        throw new \Exception($message);
    }
}
