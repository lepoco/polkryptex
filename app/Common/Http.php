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

    private static function urlFix(string $p): string
    {
        $p = str_replace('\\', '/', trim($p));
        return (substr($p, -1) != '/') ? $p .= '/' : $p;
    }
}
