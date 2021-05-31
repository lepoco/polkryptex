<?php

/**
 * @package   Polkryptex
 *
 * @copyright Copyright (c) 2021 - Kacper J., Pawel L., Filip S., Szymon K., Leszek P.
 * @license   https://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace Polkryptex\Core;

/**
 * @author Leszek P.
 */
final class User
{
    public function getId(): ?int
    {
        return '';
    }

    public function getEmail(): ?string
    {
        return '';
    }

    public function getRole(): ?string
    {
        return '';
    }

    public function getImage(): ?string
    {
        return '';
    }

    public function getAccounts(bool $reCache = false): array
    {
        return [];
    }

    public function getTransactions(bool $reCache = false): array
    {

    }

    public function isLoggedIn(): bool
    {
        return false;
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
