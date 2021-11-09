<?php

/**
 * We load application resources before starting tests
 *
 * @author  Pomianowski <kontakt@rapiddev.pl>
 * @license GPL-3.0 https://www.gnu.org/licenses/gpl-3.0.txt
 * @since   1.1.0
 */

define('APPSTART', microtime(true));
define('ABSPATH', __DIR__ . '/../../');
define('APPDIR', 'app/');

date_default_timezone_set('UTC');

require __DIR__ . '/../../vendor/autoload.php';

$app = new \App\Common\App();
