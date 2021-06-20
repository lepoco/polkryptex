<?php

/**
 * @package   Polkryptex
 *
 * @copyright Copyright (c) 2021 - Kacper J., Pawel L., Filip S., Szymon K., Leszek P.
 * @license   https://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace Polkryptex\Core\Components;

use Polkryptex\Core\Registry;

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

    public static function getUserToken(int $id): string
    {
        $query = Registry::get('Database')->query("SELECT user_session_token FROM " . self::USERS_TABLE . " WHERE user_id = ?", $id)->fetchArray();

        if(!isset($query['user_session_token']))
        {
            return null;
        }

        return $query['user_session_token'];
    }

    public static function setCookieToken(int $id, string $token): bool
    {
        $query = Registry::get('Database')->query("UPDATE " . self::USERS_TABLE . " SET user_cookie_token = ? WHERE user_id = ?", $token, $id);

        return $query->affectedRows() > 0;
    }

    public static function getCookieToken(int $id): string
    {
        $query = Registry::get('Database')->query("SELECT user_cookie_token FROM " . self::USERS_TABLE . " WHERE user_id = ?", $id)->fetchArray();

        if(!isset($query['user_cookie_token']))
        {
            return null;
        }

        return $query['user_cookie_token'];
    }
}
