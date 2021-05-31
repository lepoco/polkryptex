<?php

/**
 * @package   Polkryptex
 *
 * @copyright Copyright (c) 2021 - Kacper J., Pawel L., Filip S., Szymon K., Leszek P.
 * @license   https://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace Polkryptex\Core;

/**
 * @author Leszek P.
 */
final class Http
{
    public static function isSsl()
    {
        return !empty($_SERVER['HTTPS']);
    }

    public static function baseUrl(?string $join = null): string
    {
        return self::urlFix((self::isSsl() ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME'])) . $join;
    }

    public static function urlFix(string $requestUri): string
    {
        $requestUri = str_replace('\\', '/', trim($requestUri));
        return (substr($requestUri, -1) != '/') ? $requestUri .= '/' : $requestUri;
    }

    public static function internalRedirect(string $path = '/', bool $cache = false, bool $permanent = false)
    {
        self::redirect(self::baseUrl($path), $cache, $permanent);
    }

    public static function redirect(string $path = '/', bool $cache = false, bool $permanent = false)
    {
        header('Expires: on, 01 Jan 1970 00:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        if(!$cache)
        {
            header('Cache-Control: no-store, no-cache, must-revalidate');
            header('Cache-Control: post-check=0, pre-check=0', false);
            header('Pragma: no-cache');
        }

        if($permanent)
        {
            header('HTTP/1.1 301 Moved Permanently');
        }
        
        header('Location: ' . $path);
    }
}
