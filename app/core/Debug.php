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
    private ?Logger $errorLog = null;

    public function __construct()
    {
        $this->monolog = new Logger('APP');
        $this->monolog->pushHandler(new StreamHandler(ABSPATH . 'logs/info/' . date('Y-m-d') . '.log'));

        $this->errorLog = new Logger('APP');
        $this->errorLog->pushHandler(new StreamHandler(ABSPATH . 'logs/error/' . date('Y-m-d') . '.log'));
    }

    public static function isDebug(): bool
    {
        return (defined('APP_DEBUG') && APP_DEBUG) || !defined('APP_VERSION');
    }

    public static function isMailDebug(): bool
    {
        return (defined('APP_DEBUG_MAIL') && APP_DEBUG_MAIL);
    }

    public function close(): void
    {
        $this->monolog->close();
    }

    public function info(string $message, ?array $context = [], bool $errorLog = false): void
    {
        $context = $this->updateContext($context);

        if ($errorLog && $this->monolog != null) {
            $this->errorLog->addRecord(Logger::INFO, $message, $context);

            return;
        }

        if ($this->monolog != null) {
            $this->monolog->addRecord(Logger::INFO, $message, $context);
        }
    }

    public function error(string $message, ?array $context = [], bool $errorLog = false): void
    {
        $context = $this->updateContext($context);

        if ($errorLog && $this->monolog != null) {
            $this->errorLog->addRecord(Logger::ERROR, $message, $context);

            return;
        }

        if ($this->monolog != null) {
            $this->monolog->addRecord(Logger::ERROR, $message, $context);
        }
    }

    public function warning(string $message, ?array $context = [], bool $errorLog = false): void
    {
        $context = $this->updateContext($context);

        if ($errorLog && $this->monolog != null) {
            $this->errorLog->addRecord(Logger::WARNING, $message, $context);

            return;
        }

        if ($this->monolog != null) {
            $this->monolog->addRecord(Logger::WARNING, $message, $context);
        }
    }

    public function critical(string $message, ?array $context = [], bool $errorLog = false): void
    {
        $context = $this->updateContext($context);

        if ($errorLog && $this->monolog != null) {
            $this->errorLog->addRecord(Logger::CRITICAL, $message, $context);

            return;
        }

        if ($this->monolog != null) {
            $this->monolog->addRecord(Logger::CRITICAL, $message, $context);
        }
    }

    public function alert(string $message, ?array $context = [], bool $errorLog = false): void
    {
        $context = $this->updateContext($context);

        if ($errorLog && $this->monolog != null) {
            $this->errorLog->addRecord(Logger::ALERT, $message, $context);

            return;
        }

        if ($this->monolog != null) {
            $this->monolog->addRecord(Logger::ALERT, $message, $context);
        }
    }

    public function emergency(string $message, ?array $context = [], bool $errorLog = false): void
    {
        $context = $this->updateContext($context);

        if ($errorLog && $this->monolog != null) {
            $this->errorLog->addRecord(Logger::EMERGENCY, $message, $context);

            return;
        }

        if ($this->monolog != null) {
            $this->monolog->addRecord(Logger::EMERGENCY, $message, $context);
        }
    }

    public function errorHandler($errno, $errstr, $errfile, $errline): bool
    {
        $errstr = htmlspecialchars($errstr);
        $context = [
            'type' => 'UNKNOWN',
            'line' => $errline,
            'file' => $errfile,
            'v' => PHP_VERSION,
            'os' => PHP_OS
        ];

        switch ($errno) {
            case E_USER_ERROR:
                $context['line'] = $errline;
                $context['file'] = $errfile;
                $context['type'] = 'E_USER_ERROR';

                dump("[$errno] $errstr", $context);
                $this->emergency("[$errno] $errstr", $context, true);
                exit(1);

            case E_USER_WARNING:
                $context['type'] = 'E_USER_WARNING';
                $this->alert("[$errno] $errstr", $context, true);
                break;

            case E_USER_NOTICE:
                $context['type'] = 'E_USER_NOTICE';
                $this->critical("[$errno] $errstr", $context, true);
                break;

            default:
                $this->emergency("[$errno] $errstr", $context, true);
                break;
        }

        $this->showError(false, $errstr, $errline, $errfile, $errno);

        return true;
    }

    public function exceptionHandler($exception): bool
    {
        $errstr = htmlspecialchars($exception->getMessage());
        $context = [
            'line' => $exception->getLine(),
            'file' => $exception->getFile(),
            'v' => PHP_VERSION,
            'os' => PHP_OS
        ];

        $trace = $exception->getTrace();
        foreach ($trace as $key => $stackPoint) {
            $trace[$key]['args'] = array_map('gettype', $trace[$key]['args']);
        }

        $result = array();
        foreach ($trace as $key => $stackPoint) {
            $result[] = sprintf(
                "#%s %s(%s): %s(%s)",
                $key,
                $stackPoint['file'],
                $stackPoint['line'],
                $stackPoint['function'],
                implode(', ', $stackPoint['args'])
            );
        }

        $this->emergency('EXCEPTION: ' . $errstr, $context, true);
        $this->showError(true, $errstr, $exception->getLine(), $exception->getFile(), null, $result);

        return true;
    }

    public function exception($exception): void
    {
        $this->critical('EXCEPTION: ' . $exception->getMessage());
        echo $exception->getMessage();
    }

    private function updateContext(array $context): array
    {
        $context['ip'] = Registry::get('Request')->getRemoteAddress();
        $context['path'] = Registry::get('Request')->getUrl()->getPath();
        $context['port'] = Registry::get('Request')->getUrl()->getPort();
        $context['user-agent'] = Registry::get('Request')->getHeader('User-Agent');

        return $context;
    }

    private function showError(bool $exception, ?string $message, ?string $line, ?string $file, ?string $errorNumber = null, ?array $trace = null): void
    {
        if (!defined('APP_DEBUG_DISPLAY')) {
            return;
        }

        if (!APP_DEBUG_DISPLAY) {
            return;
        }

        $html = '<div style="font-family: Lucida Console,Lucida Sans Typewriter,monaco,Bitstream Vera Sans Mono,monospace;border:1px solid red;padding:1rem;margin:1rem;">';
        $html .= '<h4>' . ($exception ? 'EXCEPTION!' : 'ERROR #' . $errorNumber) . '</h4>';
        $html .= '<p>' . $message . '<br/><small>[' . $line . '] ' . $file . '</small></p>';

        if (null !== $trace) {
            $html .= implode("<br />", $trace);
        }

        echo $html . '</div>';
    }
}
