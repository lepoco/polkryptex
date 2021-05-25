<?php

/**
 * @package   CYPRO
 *
 * @copyright Copyright (c) 2021 - Kacper J., Pawel L., Filip S., Szymon K., Leszek P.
 * @license   https://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace Duit;

define('APPDIR', 'app/');
define('ABSPATH', dirname(__FILE__) . '\\..\\');

if (version_compare($ver = PHP_VERSION, $req = '7.4.0', '<')) {
    exit('FATAL ERROR: PHP Outdated');
}

if (!is_file(ABSPATH . 'vendor/autoload.php')) {
    exit('FATAL ERROR: Composer not found');
}


if (!is_file(ABSPATH . APPDIR . 'config.php')) {
    exit('FATAL ERROR: Config not found');
}

date_default_timezone_set('UTC');


require_once ABSPATH . APPDIR . 'config.php';
require_once ABSPATH . 'vendor/autoload.php';