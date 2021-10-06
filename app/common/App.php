<?php

namespace App\Common;

use App\Core\Bootstrap;
use App\Common\Routes;
use App\Core\Data\Config;
use App\Core\Utils\Path;

/**
 * Main class of the application. Contains all logic.
 *
 * @author  Pomianowski <kontakt@rapiddev.pl>
 * @license GPL-3.0 https://www.gnu.org/licenses/gpl-3.0.txt
 * @since   1.1.0
 */
final class App extends Bootstrap implements \App\Core\Schema\App
{
  private const ENCRYPTION_ALGO = '';

  private const SALT_SESSION = '';
  private const SALT_COOKIE = '';
  private const SALT_PASSWORD = '';
  private const SALT_NONCE = '';
  private const SALT_TOKEN = '';
  private const SALT_WEBAUTH = '';

  private const DATABASE_NAME = '';
  private const DATABASE_USER = '';
  private const DATABASE_PASS = '';
  private const DATABASE_HOST = '127.0.0.1';

  /**
   * Method triggered in setup.
   */
  public function init(): void
  {
    $this
      ->setRouter(new Routes())
      ->setConfig(
        new Config([
          'app' => [
            'name' => 'Polkryptex',
            'version' => '1.1.0',
            'log_level' => 'debug',
            'debug' => true
          ],
          'database' => [
            'default' => 'default',
            'connections' => [
              'default' => [
                'driver' => 'mysql',
                'host' => self::DATABASE_HOST,
                'port' => '3306',
                'database' => self::DATABASE_NAME,
                'username' => self::DATABASE_USER,
                'password' => self::DATABASE_PASS,
                'collation' => 'utf8_general_ci',
                'charset' => 'utf8',
                'strict' => false,
              ]
            ]
          ],
          'encryption' => [
            'algorithm' => self::ENCRYPTION_ALGO
          ],
          'salts' => [
            'session' => self::SALT_SESSION,
            'cookie' => self::SALT_COOKIE,
            'password' => self::SALT_PASSWORD,
            'nonce' => self::SALT_NONCE,
            'token' => self::SALT_TOKEN,
            'webauth' => self::SALT_WEBAUTH
          ],
          'storage' => [
            'logs' => Path::getAppPath('storage/logs'),
            'uploads' => Path::getAbsolutePath('public/assets/uploads')
          ],
          'logging' => [
            'default' => 'daily',
            'channels' => [
              'daily' => [
                'name' => 'POLKRYPTEX',
                'driver' => 'daily',
                'path' => Path::getAppPath('storage/logs/daily.log'),
                'level' => 'debug',
                'days' => 31
              ]
            ]
          ],
          'session' => [
            'lifetime' => 60,
            'files' => Path::getAppPath('storage/session')
          ],
          'view' => [
            'paths' => [Path::getAppPath('common/views')],
            'emails' => [Path::getAppPath('common/views/emails')],
            'compiled' => Path::getAppPath('storage/blade'),
            'composers' => Path::getAppPath('common/composers')
          ],
          'cache' => [
            'default' => 'file',
            'stores' => [
              'file' => [
                'driver' => 'file',
                'path' => Path::getAppPath('storage/cache'),
              ]
            ]
          ]
        ])
      );
  }
}
