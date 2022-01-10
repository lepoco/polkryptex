<?php

/**
 * This is where the request made by the browser begins.
 *
 * @author  Pomianowski <support@polkryptex.pl>
 * @license GPL-3.0 https://www.gnu.org/licenses/gpl-3.0.txt
 * @since   1.1.0
 */

define('APPDEBUG', true);
define('APPSTART', microtime(true));
define('ABSPATH', __DIR__ . '/../');
define('APPDIR', 'app/');

define('SUPPORTEMAIL', 'webmaster@polkryptex.pl');

date_default_timezone_set('UTC');

require __DIR__ . '/../vendor/autoload.php';

\App\Core\Utils\ErrorHandler::register();

(new \App\Common\App())
  ->setup()
  ->connect()
  ->print()
  ->close();
