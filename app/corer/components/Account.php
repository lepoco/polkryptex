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
final class Account
{
    private User $currentUser;

    private array $roles;

    public function currentUser(): User
    {
        if(isset($this->currentUser))
        {
            return $this->currentUser;
        }

        return new User();
    }

    public function signIn(User $user): void
    {
        if(!$user->isValid())
        {
            return;
        }

        //todo
        Registry::get('Session')->regenerateId();
    }

    public function signOut(): void
    {
        Registry::get('Session')->destroy();
    }

    public function getRoles(): array
    {
        if(isset($this->roles))
        {
            return $this->$roles;
        }

        $dbRoles = Query::getRoles();

        $this->roles = [];
        foreach ($dbRoles as $key => $role) {
            $this->roles[] = [
                'id' => $role['role_id'],
                'name' => $role['role_name'],
                'permissions' => json_decode($role['role_permissions'])
            ];
        }

        return $this->roles;
    }

    public static function hasPermission(string $permission): bool
    {
        return true;
    }
}
