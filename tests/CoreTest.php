<?php

namespace Tests;

test('PHP version at least 7.4', function () {
  expect(version_compare($ver = PHP_VERSION, $req = '7.4.0', '>='))->toBeTrue();
});

test('Mysqli library installed', function () {
  expect(extension_loaded('Mysqli'))->toBeTrue();
});

test('GD library installed', function () {
  expect(extension_loaded('gd'))->toBeTrue();
});

test('Blade package installed', function () {
  expect(class_exists('\Jenssegers\Blade\Blade'))->toBeTrue();
});

test('Bramus Router package installed', function () {
  expect(class_exists('\Bramus\Router\Router'))->toBeTrue();
});

test('Nette HTTP package installed', function () {
  expect(class_exists('\Nette\Http\Session'))->toBeTrue();
});

test('Monolog package installed', function () {
  expect(class_exists('\Monolog\Logger'))->toBeTrue();
});

test('PHPMailer package installed', function () {
  expect(class_exists('\PHPMailer\PHPMailer\PHPMailer'))->toBeTrue();
});

test('Application common folder exists', function () {
  expect(is_dir(dirname(__FILE__) . '/../app/common/'))->toBeTrue();
});

test('Database structure file exists', function () {
  expect(is_file(dirname(__FILE__) . '/../app/database/database.sql'))->toBeTrue();
});

test('Configuration file exists', function () {
  expect(is_file(dirname(__FILE__) . '/../app/config.php'))->toBeTrue();
});