<?php

/**
 * @package   Polkryptex
 *
 * @copyright Copyright (c) 2021 - Kacper J., Pawel L., Filip S., Szymon K., Leszek P.
 * @license   https://www.gnu.org/licenses/gpl-3.0.txt
 */

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('error_reporting', E_ALL);

define('POLKRYPTEX_VERSION', '1.0.1');
define('APPDIR', 'app\\');
define('ABSPATH', dirname(__FILE__) . '\\..\\');

if (version_compare($ver = PHP_VERSION, $req = '7.4.0', '<')) {
    exit('FATAL ERROR: PHP Outdated');
}

if (!is_file(ABSPATH . 'vendor/autoload.php')) {
    exit('FATAL ERROR: Composer not found');
}

if (is_file(ABSPATH . APPDIR . 'config.php')) {
    require_once ABSPATH . APPDIR . 'config.php';
}

date_default_timezone_set('UTC');

require_once ABSPATH . 'vendor/autoload.php';

(new App\Common\App());
