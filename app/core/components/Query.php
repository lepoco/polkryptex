<?php

/**
 * @package   Polkryptex
 *
 * @copyright Copyright (c) 2021 - Kacper J., Pawel L., Filip S., Szymon K., Leszek P.
 * @license   https://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace App\Core\Components;

use \DateTime;
use Ramsey\Uuid\Uuid;
use App\Core\Registry;
use App\Core\Components\Crypter;
use App\Core\Components\Utils;

/**
 * @author Leszek P.
 */
final class Query
{
    private const USERS_TABLE = 'pkx_users';
    private const USER_ROLES_TABLE = 'pkx_user_roles';

    public static function getUserById($id): array
    {
        return Registry::get('Database')->query("SELECT * FROM " . self::USERS_TABLE . " WHERE user_id = ?", $id)->fetchArray();
    }

    public static function getUserByName($name): array
    {
        return Registry::get('Database')->query("SELECT * FROM " . self::USERS_TABLE . " WHERE user_name = ?", $name)->fetchArray();
    }

    public static function getUserByEmail($email): array
    {
        return Registry::get('Database')->query("SELECT * FROM " . self::USERS_TABLE . " WHERE user_email = ?", $email)->fetchArray();
    }

    public static function getRoles(): array
    {
        return Registry::get('Database')->query("SELECT * FROM " . self::USER_ROLES_TABLE)->fetchAll();
    }

    public static function setUserToken(int $id, string $token): bool
    {
        $query = Registry::get('Database')->query("UPDATE " . self::USERS_TABLE . " SET user_session_token = ? WHERE user_id = ?", $token, $id);

        return $query->affectedRows() > 0;
    }

    public static function getUserToken(int $id): ?string
    {
        $query = Registry::get('Database')->query("SELECT user_session_token FROM " . self::USERS_TABLE . " WHERE user_id = ?", $id)->fetchArray();

        if (!isset($query['user_session_token'])) {
            return null;
        }

        return $query['user_session_token'];
    }

    public static function setCookieToken(int $id, string $token): bool
    {
        $query = Registry::get('Database')->query("UPDATE " . self::USERS_TABLE . " SET user_cookie_token = ? WHERE user_id = ?", $token, $id);

        return $query->affectedRows() > 0;
    }

    public static function getCookieToken(int $id): ?string
    {
        $query = Registry::get('Database')->query("SELECT user_cookie_token FROM " . self::USERS_TABLE . " WHERE user_id = ?", $id)->fetchArray();

        if (!isset($query['user_cookie_token'])) {
            return null;
        }

        return $query['user_cookie_token'];
    }

    public static function updateLastLogin(int $id): bool
    {
        //TODO fix timezone
        $query = Registry::get('Database')->query("UPDATE " . self::USERS_TABLE . " SET user_last_login = ? WHERE user_id = ?", (new DateTime())->format('Y-m-d H:i:s'), $id);

        return $query->affectedRows() > 0;
    }

    public static function updateUserDisplayName(int $id, string $name): bool
    {
        $query = Registry::get('Database')->query("UPDATE " . self::USERS_TABLE . " SET user_display_name = ? WHERE user_id = ?", $name, $id);

        return $query->affectedRows() > 0;
    }

    public static function updateUserImage(int $id, string $image): bool
    {
        $query = Registry::get('Database')->query("UPDATE " . self::USERS_TABLE . " SET user_image = ? WHERE user_id = ?", $image, $id);

        return $query->affectedRows() > 0;
    }

    public static function updateUserPassword(int $id, string $plainPassword): bool
    {
        $query = Registry::get('Database')->query("UPDATE " . self::USERS_TABLE . " SET user_password = ? WHERE user_id = ?", Crypter::encrypt($plainPassword, 'password'), $id);

        return $query->affectedRows() > 0;
    }

    public static function addUser(string $username, string $email, string $plainPassword): bool
    {
        $roles = self::getRoles();
        $role = 4;

        if (!empty($roles)) {
            foreach ($roles as $id => $role) {
                if ('client' === $role['role_name']) {
                    $role = ($id + 1); //MySQL runs the index from 1 not from 0
                    break;
                }
            }
        }

        $token = Crypter::salter(32);
        $query = Registry::get('Database')->query(
            "INSERT INTO " . self::USERS_TABLE . " (user_name, user_display_name, user_email, user_password, user_session_token, user_uuid, user_role, user_status) VALUES (?,?,?,?,?,?,?,0)",
            Utils::alphaUsername($username),
            $username,
            $email,
            Crypter::encrypt($plainPassword, 'password'),
            Crypter::encrypt($token, 'session'),
            Uuid::uuid5(APP_USERS_NAMESPACE, 'user/' . $username)->toString(),
            intval($role)
        );

        return $query->affectedRows() > 0;
    }
}
