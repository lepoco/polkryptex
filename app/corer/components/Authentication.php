<?php

/**
 * @package   Polkryptex
 *
 * @copyright Copyright (c) 2021 - Kacper J., Pawel L., Filip S., Szymon K., Leszek P.
 * @license   https://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace Polkryptex\Core\Components;

/**
 * @author Leszek P.
 */
final class Auhtentication
{
    public function signIn(): ?int
    {
        return '';
    }

    public function signOut(): ?int
    {
        return '';
    }

    public function setSession(): ?int
    {
        return '';
    }

    public function getSession(): ?int
    {
        return '';
    }

    private function verifyToken(): ?int
    {
        return '';
    }

    private function verifyTimestamp(): ?int
    {
        return '';
    }

    private function verifyIp(): ?int
    {
        return '';
    }
}
