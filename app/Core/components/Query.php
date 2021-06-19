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

    public static function getUserById($id)
    {
        return Registry::get('Database')->query("SELECT * FROM " . self::USERS_TABLE . " WHERE user_id = ?", $id)->fetchArray();
    }

    public static function getUserByName($name)
    {
        return Registry::get('Database')->query("SELECT * FROM " . self::USERS_TABLE . " WHERE user_name = ?", $name)->fetchArray();
    }

    public static function getUserByEmail($email)
    {
        return Registry::get('Database')->query("SELECT * FROM " . self::USERS_TABLE . " WHERE user_email = ?", $email)->fetchArray();
    }

    public static function getRoles()
    {
        return Registry::get('Database')->query("SELECT * FROM " . self::USER_ROLES_TABLE)->fetchAll();
    }
}
