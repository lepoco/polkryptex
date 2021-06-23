<?php

/**
 * @package   Polkryptex
 *
 * @copyright Copyright (c) 2021 - Kacper J., Pawel L., Filip S., Szymon K., Leszek P.
 * @license   https://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace App\Core\Components;

use App\Core\Registry;
use App\Core\Components\Query;
use App\Core\Components\Crypter;

/**
 * @author Leszek P.
 */
final class User
{
    private ?int $id = null;

    private ?int $role = null;

    private ?bool $status = null;

    private ?string $uuid = null;

    private ?string $username = null;

    private ?string $displayName = null;

    private ?string $email = null;

    private ?string $image = null;

    private ?string $password = null;

    private ?string $sessionToken = null;

    private ?string $cookieToken = null;

    public static function findByName($username): self
    {
        $query = Query::getUserByName($username);

        if (empty($query)) {
            return new self();
        }

        return (new self())->__fromDB($query);
    }

    public static function findByEmail($email): self
    {
        $query = Query::getUserByEmail($email);

        if (empty($query)) {
            return new self();
        }

        return (new self())->__fromDB($query);
    }

    public static function fromId(int $id): self
    {
        $query = Query::getUserById($id);

        if (empty($query)) {
            return new self();
        }

        return (new self())->__fromDB($query);
    }

    private function __fromDB(array $database): self
    {
        $this->id = intval($database['user_id'] ?? 0);
        $this->role = intval($database['user_role'] ?? 0);
        $this->status = (1 === $database['user_status']);
        $this->password = $database['user_password'] ?? '';
        $this->uuid = $database['user_uuid'] ?? '';
        $this->username = $database['user_name'] ?? '';
        $this->displayName = $database['user_display_name'] ?? '';
        $this->email = $database['user_email'] ?? '';
        $this->image = $database['user_image'] ?? '';
        $this->sessionToken = $database['user_session_token'] ?? '';
        $this->cookieToken = $database['user_cookie_token'] ?? '';

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRole(): ?int
    {
        return $this->role;
    }

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function getUUID(): ?string
    {
        return $this->uuid;
    }

    public function getName(): ?string
    {
        return $this->username;
    }

    public function getDisplayName(): ?string
    {
        return $this->displayName;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function getWallets(bool $reCache = false): array
    {
        return [];
    }

    public function getTransactions(bool $reCache = false): array
    {
        return [];
    }

    public function checkPassword(string $password): bool
    {
        return Crypter::compare($password, $this->password, 'password');
    }

    public function checkSessionToken(string $token): bool
    {
        return Crypter::compare($token, $this->sessionToken, 'session');
    }

    public function checkCookieToken(string $token): bool
    {
        return Crypter::compare($token, $this->cookieToken, 'cookie');
    }

    public function isValid(): bool
    {
        return $this->id != null && $this->id > 0;
    }

    public function isAdmin(): bool
    {
        return false;
    }

    public function isManager(): bool
    {
        return false;
    }
}
