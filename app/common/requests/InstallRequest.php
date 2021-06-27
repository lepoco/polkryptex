<?php

/**
 * @package   Polkryptex
 *
 * @copyright Copyright (c) 2021 - Kacper J., Pawel L., Filip S., Szymon K., Leszek P.
 * @license   https://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace App\Common\Requests;

use Mysqli;
use Ramsey\Uuid\Uuid;
use App\Core\Database;
use App\Core\Request;
use App\Core\Registry;
use App\Core\Components\Utils;
use App\Core\Components\Crypter;

/**
 * @author Leszek P.
 */
final class InstallRequest extends Request
{
    private ?string $usersNamespace = null;

    private ?string $transationsNamespace = null;

    private ?string $passwordSalt = null;

    private /*Mixed*/ $passwordAlgo = null;

    public function action(): void
    {
        $this->isInstalled();

        $this->isSet([
            'user',
            'password',
            'host',
            'table',
            'admin_username',
            'admin_email',
            'admin_password'
        ]);

        $this->isEmpty([
            'user',
            'host',
            'table',
            'admin_username',
            'admin_email',
            'admin_password'
        ]);

        $this->validate([
            ['user'],
            ['password'],
            ['host'],
            ['table'],
            ['admin_username'],
            ['admin_email'],
            ['admin_password']
        ]);

        $this->isMysql();
        $this->createConfig();
        $this->createHtaccess();
        $this->createDatabase();
        $this->fillDatabase();

        $this->finish(self::CODE_SUCCESS);
    }


    private function createConfig(): void
    {
        $this->usersNamespace = Uuid::uuid4()->toString();
        $this->transationsNamespace = Uuid::uuid4()->toString();

        $this->passwordSalt = Crypter::salter(64);

        $config  = '<?php' . "\n";
        $config .= "\n" . '/**';
        $config .= "\n" . ' * @package   Polkryptex';
        $config .= "\n" . ' *';
        $config .= "\n" . ' * @copyright Copyright (c) 2021 - Kacper J., Pawel L., Filip S., Szymon K., Leszek P.';
        $config .= "\n" . ' * @license   https://www.gnu.org/licenses/gpl-3.0.txt';
        $config .= "\n" . ' */';
        $config .= "\n";
        $config .= "\n" . 'namespace App;';
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
        $config .= "\n" . 'define(\'APP_COOKIE_SALT\', \'' . Crypter::salter(64) . '\');';
        $config .= "\n" . 'define(\'APP_PASSWORD_SALT\', \'' . $this->passwordSalt . '\');';
        $config .= "\n" . 'define(\'APP_NONCE_SALT\', \'' . Crypter::salter(64) . '\');';
        $config .= "\n";
        $config .= "\n" . 'define(\'APP_USERS_NAMESPACE\', \'' . $this->usersNamespace . '\');';
        $config .= "\n" . 'define(\'APP_TRANSACTIONS_NAMESPACE\', \'' . $this->transationsNamespace . '\');';
        $config .= "\n";
        $config .= "\n" . 'define(\'APP_UPLOADS\', \'media/uploads/\');';
        $config .= "\n" . 'define(\'APP_DEBUG\', true);';
        $config .= "\n" . 'define(\'APP_DEBUG_DISPLAY\', true);';
        $config .= "\n";

        $path = ABSPATH . APPDIR . 'config.php';
        file_put_contents($path, $config);

        Registry::get('Debug')->info('Configuration file has been created', ['request' => 'App\Common\Requests\Install']);
    }

    private function createHtaccess(string $dir = '/'): void
    {
        if ($dir == '/') {
            $dir = '';
        }

        $htaccess =         'Options All -Indexes';
        $htaccess .= "\n" . 'AddDefaultCharset UTF-8';
        $htaccess .= "\n";
        $htaccess .= "\n" . '<IfModule mod_headers.c>';
        $htaccess .= "\n" . '  Header unset ETag';
        $htaccess .= "\n" . '</IfModule>';
        $htaccess .= "\n" . 'FileETag None';
        $htaccess .= "\n";
        $htaccess .= "\n" . '<IfModule mod_expires.c>';
        $htaccess .= "\n" . '    ExpiresActive off';
        $htaccess .= "\n" . '</IfModule>';
        $htaccess .= "\n";
        $htaccess .= "\n" . '<IfModule mod_rewrite.c>';
        $htaccess .= "\n" . '    RewriteEngine On';
        $htaccess .= "\n" . '    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]';
        $htaccess .= "\n" . '    RewriteBase /';
        $htaccess .= "\n" . '    RewriteRule ^index\.php$ - [L]';
        $htaccess .= "\n" . '    RewriteCond %{REQUEST_FILENAME} !-f';
        $htaccess .= "\n" . '    RewriteCond %{REQUEST_FILENAME} !-d';
        $htaccess .= "\n" . '    RewriteRule . ' . $dir . 'index.php [L]';
        $htaccess .= "\n" . '</IfModule>';
        $htaccess .= "\n";
        $htaccess .= "\n" . '<FilesMatch "\.(webmanifest)$">';
        $htaccess .= "\n" . '    Header set Content-Type "application/manifest+json; charset=utf-8"';
        $htaccess .= "\n" . '    Header set Cache-Control "max-age=31536000, immutable"';
        $htaccess .= "\n" . '    Header set X-Content-Type-Options "nosniff"';
        $htaccess .= "\n" . '</FilesMatch>';
        $htaccess .= "\n";
        $htaccess .= "\n" . '<FilesMatch "\.(ico|pdf|jpg|jpeg|png|gif|css|svg|svg+xml|json|js)$">';
        $htaccess .= "\n" . '    AddDefaultCharset UTF-8';
        $htaccess .= "\n" . '    Header set Cache-Control "max-age=31536000, immutable"';
        $htaccess .= "\n" . '    Header set X-Content-Type-Options "nosniff"';
        $htaccess .= "\n" . '</FilesMatch>';

        $path = ABSPATH . 'public/.htaccess';
        file_put_contents($path, $htaccess);

        Registry::get('Debug')->info('.htaccess file has been created', ['request' => 'App\Common\Requests\Install']);
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

        Registry::get('Debug')->info('Tables for the database have been created', ['request' => 'App\Common\Requests\Install', 'sql' => ABSPATH . APPDIR . 'database/database.sql']);
    }

    private function fillDatabase(): void
    {
        $database = new Database($this->getData('host'), $this->getData('user'), $this->getData('password'), $this->getData('table'));

        if (!$database->isConnected()) {
            $this->finish(self::ERROR_MYSQL_UNKNOWN);
        }

        $database->query("INSERT IGNORE INTO pkx_options (option_name, option_value) VALUES ('host', ?)", $this->request->url->host);
        $database->query("INSERT IGNORE INTO pkx_options (option_name, option_value) VALUES ('seured', ?)", $this->request->isSecured() ? 'true' : 'false');

        $baseurl = ($this->request->isSecured() ? 'https://' : 'http://') . $this->request->url->host . '/';
        $database->query("INSERT IGNORE INTO pkx_options (option_name, option_value) VALUES ('baseurl', ?)", $baseurl);
        $database->query("INSERT IGNORE INTO pkx_options (option_name, option_value) VALUES ('home', ?)", $baseurl);

        $database->query(
            "INSERT IGNORE INTO pkx_options (option_name, option_value) VALUES " .
                "('version', '" . POLKRYPTEX_VERSION . "'), " .
                "('site_name', 'Polkryptex'),  " .
                "('site_description', 'Trust us with your money'),  " .
                "('dashboard', 'dashboard'),  " .
                "('timezone', 'UTC'), " .
                "('date_format', 'j F Y'), " .
                "('time_format', 'H:i'), " .
                "('record_date_format', 'j F Y'), " .
                "('charset', 'UTF8'), " .
                "('cache', 'false'), " .
                "('gzip', 'false'),  " .
                "('language', 'pl'),  " .
                "('language_mode', '1'),  " .
                "('login_timeout', '10'),  " .
                "('signin_captcha', 'false'), " .
                "('captcha_public', ''), " .
                "('captcha_secret', ''), " .
                "('force_ssl', 'false'), " .
                "('store_ip_addresses', 'true'), " .
                "('redirect_404', 'false'), " .
                "('redirect_404_direction', ''), " .
                "('redirect_home', 'false'), " .
                "('redirect_home_direction', ''), " .
                "('google_analytics', '')"
        );

        $database->query(
            "INSERT IGNORE INTO pkx_user_roles (role_name, role_permissions) VALUES " .
                "('administrator', '{\"permissions\":[\"all\"]}'), " .
                "('manager', '{\"permissions\":[]}'), " .
                "('analyst', '{\"permissions\":[]}'), " .
                "('client', '{\"permissions\":[]}')"
        );

        $database->query(
            "INSERT IGNORE INTO pkx_user_plans (plan_name, plan_capabilities) VALUES " .
                "('standard', '{\"capabilities\":[]}'), " .
                "('plus', '{\"capabilities\":[]}'), " .
                "('premium', '{\"capabilities\":[]}'), " .
                "('trader', '{\"capabilities\":[\"all\"]}')"
        );

        //At this point, we need a configuration file
        //as it has encryption salts stored in it
        // if (is_file(ABSPATH . APPDIR . 'config.php')) {
        //     require_once ABSPATH . APPDIR . 'config.php';
        // }

        //drop database polkryptex;create database polkryptex;

        $database->query(
            "INSERT IGNORE INTO pkx_users (user_name, user_display_name, user_email, user_password, user_uuid, user_role, user_status) VALUES (?,?,?,?,?,1,1)",
            Utils::alphaUsername($this->getData('admin_username')),
            $this->getData('admin_username'),
            $this->getData('admin_email'),
            Crypter::encrypt($this->getData('admin_password'), 'password', $this->passwordSalt, $this->passwordAlgo),
            Uuid::uuid5($this->usersNamespace, 'user/' . $this->getData('admin_username'))->toString()
        );
        unset($database);
    }

    private function getAlgorithm(): string
    {
        /** Password hash type */
        if (defined('PASSWORD_ARGON2ID')) {
            $this->passwordAlgo = PASSWORD_ARGON2ID;
            return 'PASSWORD_ARGON2ID';
        } else if (defined('PASSWORD_ARGON2I')) {
            $this->passwordAlgo = PASSWORD_ARGON2I;
            return 'PASSWORD_ARGON2I';
        } else if (defined('PASSWORD_BCRYPT')) {
            $this->passwordAlgo = PASSWORD_BCRYPT;
            return 'PASSWORD_BCRYPT';
        } else if (defined('PASSWORD_DEFAULT')) {
            $this->passwordAlgo = PASSWORD_DEFAULT;
            return 'PASSWORD_DEFAULT';
        }
    }

    private function isMysql(): void
    {
        error_reporting(0);
        $database = new Mysqli($this->getData('host'), $this->getData('user'), $this->getData('password'), $this->getData('table'));
        if ($database->connect_error) {
            $this->finish(self::ERROR_MYSQL_UNKNOWN, self::STATUS_GONE);
        }

        unset($database);
    }

    private function isInstalled(): void
    {
        if (defined('APP_VERSION')) {
            $this->finish(self::ERROR_ENTRY_EXISTS, self::STATUS_UNAUTHORIZED);
        }
    }
}
