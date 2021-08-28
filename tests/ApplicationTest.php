<?php
/**
 * @see https://pestphp.com/docs/skipping-tests
 */

define('ABSPATH', dirname(__FILE__) . '\\..\\');

test('Connection to the database can be established', function () {

  require_once ABSPATH . '/app/config.php';

  $db = new \App\Core\Database();

  expect($db->isConnected())->toBeTrue();
})->skip(fn () => false === is_file(ABSPATH . '/app/config.php'), 'Config.php not available');

test('Router has a class that initiates routes', function () {
  expect(method_exists('\App\Common\Routes', 'initialize'))->toBeTrue();
})->skip(fn () => false === is_file(ABSPATH . '/app/common/Routes.php'), 'Config.php not available');