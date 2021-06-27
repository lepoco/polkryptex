<?php

/**
 * @package   Polkryptex
 *
 * @copyright Copyright (c) 2021 - Kacper J., Pawel L., Filip S., Szymon K., Leszek P.
 * @license   https://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace App\Core\Components;

/**
 * @author Leszek P.
 */
final class Utils
{
    public static function alphaUsername(?string $username): string
    {
        return preg_replace("/[^a-zA-Z0-9]+/", "", trim(strtolower($username)));
    }

    public static function pascalToKebab(string $input, string $separator = '-'): string
    {
        preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $input, $matches);
        $ret = $matches[0];
        foreach ($ret as &$match) {
            $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
        }

        return implode($separator, $ret);
    }

    public static function namespaceToBlade(string $namespace): string
    {
        $view = '';
        $path = explode('\\', $namespace);
        for ($i = 0; $i < count($path); $i++) {
            $view .= ($i > 0 ? '.' : '') . self::pascalToKebab($path[$i]);
        }

        return $view;
    }

    public static function namespaceToTitle(string $namespace): string
    {
        $paths = explode('\\', $namespace);
        return trim($paths[count($paths) - 1]);
    }
}
