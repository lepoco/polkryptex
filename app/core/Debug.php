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
 * @see https://packagist.org/packages/monolog/monolog
 */
final class Debug
{
    private ?Logger $monolog = null;

    public function __construct()
    {
        $this->monolog = new Logger('APP');
        $this->monolog->pushHandler(new StreamHandler(ABSPATH . APPDIR . date('Y-m-d').'.log'));
    }

    public static function isDebug(): bool
    {
        return (defined('APP_DEBUG') && APP_DEBUG) || !defined('APP_VERSION');
    }

    public function close(): void
    {
        $this->monolog->close();
    }

    public function info(string $message, ?array $context = []): void
    {
        if ($this->monolog != null) {
            $this->monolog->addRecord(Logger::INFO, $message, $context);
        }
    }

    public function error(string$message, ?array $context = []): void
    {
        if ($this->monolog != null) {
            $this->monolog->addRecord(Logger::ERROR, $message, $context);
        }
    }

    public function warning(string$message, ?array $context = []): void
    {
        if ($this->monolog != null) {
            $this->monolog->addRecord(Logger::WARNING, $message, $context);
        }
    }

    public function critical(string$message, ?array $context = []): void
    {
        if ($this->monolog != null) {
            $this->monolog->addRecord(Logger::CRITICAL, $message, $context);
        }
    }

    public function exception(string $message): void
    {
        $this->error('EXCEPTION: ' . $message);
        throw new \Exception($message);
    }
}
