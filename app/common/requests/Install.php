<?php

/**
 * @package   Polkryptex
 *
 * @copyright Copyright (c) 2021 - Kacper J., Pawel L., Filip S., Szymon K., Leszek P.
 * @license   https://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace Polkryptex\Common\Requests;

use Mysqli;
use Polkryptex\Core\Request;
use Polkryptex\Core\Registry;
use Polkryptex\Core\Shared\Crypter;

/**
 * @author Leszek P.
 */
final class Install extends Request
{
    public function action(): void
    {
        $this->isSet([
            'user',
            'password',
            'host',
            'table',
            'admin_username',
            'admin_password'
        ]);

        $this->isEmpty([
            'user',
            'host',
            'table',
            'admin_username',
            'admin_password'
        ]);

        $this->filter([
            ['user'],
            ['password'],
            ['host'],
            ['table'],
            ['admin_username'],
            ['admin_password']
        ]);

        $this->isInstalled();
        $this->isMysql();

        $this->createConfig();
        $this->createHtaccess();
        $this->createDatabase();
        $this->fillDatabase();

        $this->finish(self::CODE_SUCCESS);
    }


    private function createConfig(): void
    {
        $config  = '<?php' . "\n";
        $config .= "\n" . '/**';
        $config .= "\n" . ' * @package   Polkryptex';
        $config .= "\n" . ' *';
        $config .= "\n" . ' * @copyright Copyright (c) 2021 - Kacper J., Pawel L., Filip S., Szymon K., Leszek P.';
        $config .= "\n" . ' * @license   https://www.gnu.org/licenses/gpl-3.0.txt';
        $config .= "\n" . ' */';
        $config .= "\n";
        $config .= "\n" . 'namespace Polkryptex;';
        $config .= "\n";
        $config .= "\n" . 'defined(\'ABSPATH\') or die(\'No script kiddies please!\');';
        $config .= "\n";
        $config .= "\n" . 'define(\'APP_VERSION\', \'' . POLKRYPTEX_VERSION . '\');';
        $config .= "\n" . 'define(\'APP_ALGO\', ' . $this->getAlgorithm() . ');';
        $config .= "\n";
        $config .= "\n" . 'define(\'APP_DB_NAME\', \'' . $this->getData('table') . '\');';
        $config .= "\n" . 'define(\'APP_DB_HOST\', \'' . $this->getData('host') . '\');';
        $config .= "\n" . 'define(\'APP_DB_USER\', \'' . $this->getData('user') . '\');';
        $config .= "\n" . 'define(\'APP_DB_PASS\', \'' . $this->getData('password') . '\');';
        $config .= "\n";
        $config .= "\n" . 'define(\'APP_SESSION_SALT\', \'' . Crypter::salter(64) . '\');';
        $config .= "\n" . 'define(\'APP_PASSWORD_SALT\', \'' . Crypter::salter(64) . '\');';
        $config .= "\n" . 'define(\'APP_NONCE_SALT\', \'' . Crypter::salter(64) . '\');';
        $config .= "\n";
        $config .= "\n" . 'define(\'APP_DEBUG\', false);';
        $config .= "\n" . 'define(\'APP_DEBUG_DISPLAY\', false);';
        $config .= "\n";

        $path = ABSPATH . APPDIR . 'config.php';
        file_put_contents($path, $config);

        Registry::get('Debug')->info('Configuration file has been created', ['request' => 'Polkryptex\Common\Requests\Install']);
    }

    private function createHtaccess(string $dir = '/'): void
    {
        if ($dir == '/')
            $dir = '';

        $htaccess  = 'Options All -Indexes';
        $htaccess .= "\n" . '<IfModule mod_rewrite.c>';
        $htaccess .= "\n" . 'RewriteEngine On';
        $htaccess .= "\n" . 'RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]';
        $htaccess .= "\n" . 'RewriteBase /';
        $htaccess .= "\n" . 'RewriteRule ^index\.php$ - [L]';
        $htaccess .= "\n" . 'RewriteCond %{REQUEST_FILENAME} !-f';
        $htaccess .= "\n" . 'RewriteCond %{REQUEST_FILENAME} !-d';
        $htaccess .= "\n" . 'RewriteRule . ' . $dir . 'index.php [L]';
        $htaccess .= "\n" . '</IfModule>';

        $path = ABSPATH . 'public/.htaccess';
        file_put_contents($path, $htaccess);

        Registry::get('Debug')->info('.htaccess file has been created', ['request' => 'Polkryptex\Common\Requests\Install']);
    }

    private function createDatabase(): void
    {
        $database = new Mysqli($this->getData('host'), $this->getData('user'), $this->getData('password'), $this->getData('table'));
        $database->set_charset('utf8');

        $databaseFile = file(ABSPATH . APPDIR . 'database/database.sql');
        $queryLine = '';

        // Loop through each line
        foreach ($databaseFile as $line) {
            //Skip comments and blanks
            if (substr($line, 0, 2) == '--' || $line == '' || substr($line, 0, 1) == '#') {
                continue;
            }

            $queryLine .= $line;
            if (substr(trim($line), -1, 1) == ';') {
                $database->query($queryLine);
                $queryLine = '';
            }
        }

        unset($database);

        Registry::get('Debug')->info('Tables for the database have been created', ['request' => 'Polkryptex\Common\Requests\Install', 'sql' => ABSPATH . APPDIR . 'database/database.sql']);
    }

    private function fillDatabase(): void
    {
    }

    private function getAlgorithm(): string
    {
        /** Password hash type */
        if (defined('PASSWORD_ARGON2ID')) {
            return 'PASSWORD_ARGON2ID';
        } else if (defined('PASSWORD_ARGON2I')) {
            return 'PASSWORD_ARGON2I';
        } else if (defined('PASSWORD_BCRYPT')) {
            return 'PASSWORD_BCRYPT';
        } else if (defined('PASSWORD_DEFAULT')) {
            return 'PASSWORD_DEFAULT';
        }
    }

    private function isMysql(): void
    {
        error_reporting(0);
        $database = new Mysqli($this->getData('host'), $this->getData('user'), $this->getData('password'), $this->getData('table'));
        if ($database->connect_error) {
            $this->finish(self::ERROR_MYSQL_UNKNOWN);
        }

        unset($database);
    }

    private function isInstalled(): void
    {
        if (defined('APP_VERSION')) {
            $this->finish(self::ERROR_ENTRY_EXISTS);
        }
    }
}
