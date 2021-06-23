<?php

/**
 * @package   Polkryptex
 *
 * @copyright Copyright (c) 2021 - Kacper J., Pawel L., Filip S., Szymon K., Leszek P.
 * @license   https://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace App\Core;

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
        if (defined('APP_DEBUG') && APP_DEBUG) {

            if (defined('APP_DEBUG_DISPLAY') && APP_DEBUG_DISPLAY) {
                ini_set('display_errors', 1);
                ini_set('display_startup_errors', 1);
                error_reporting(E_ALL);
            } else {
                error_reporting(0);
            }
        }

        $this->monolog = new Logger('Polkryptex');
        $this->monolog->pushHandler(new StreamHandler(ABSPATH . APPDIR . 'debug.log', Logger::WARNING));
    }

    public static function isDebug(): bool
    {
        return (defined('APP_DEBUG') && APP_DEBUG) || !defined('APP_VERSION');
    }

    public function info(string $message, ?array $data = []): void
    {
        if ($this->monolog != null) {
            $this->monolog->info($message, $data);
        }
    }

    public function error(string$message, ?array $data = []): void
    {
        if ($this->monolog != null) {
            $this->monolog->error($message, $data);
        }
    }

    public function warning(string$message, ?array $data = []): void
    {
        if ($this->monolog != null) {
            $this->monolog->warning($message, $data);
        }
    }

    public function exception(string $message): void
    {
        $this->error('EXCEPTION: ' . $message);
        throw new \Exception($message);
    }
}
