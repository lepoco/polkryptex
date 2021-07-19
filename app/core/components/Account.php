<?php

/**
 * @package   Polkryptex
 *
 * @copyright Copyright (c) 2021 - Kacper J., Pawel L., Filip S., Szymon K., Leszek P.
 * @license   https://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace App\Core\Components;

use DateTime;
use App\Core\Registry;

/**
 * @author Leszek P.
 */
final class Account
{
  protected \Nette\Http\Request $request;

  protected \Nette\Http\Response $response;

  private ?User $currentUser = null;

  private array $roles = [];

  public function __construct(\Nette\Http\Request $request, \Nette\Http\Response $response)
  {
    $this->request = $request;
    $this->response = $response;
  }

  public function currentUser(): User
  {
    if ($this->currentUser !== null) {
      return $this->currentUser;
    }

    $userSession = Registry::get('Session')->getSection('User');

    if (!isset($userSession->id) || !isset($userSession->token)) {
      return new User();
    }

    $this->currentUser = \App\Core\Components\User::fromId(intval($userSession->id));

    return $this->currentUser;
  }

  public function signIn(User $user, string $cookieToken): void
  {
    if (!$user->isValid()) {
      return;
    }

    $userSession = Registry::get('Session')->getSection('User');
    $token = Crypter::salter(32);

    $userSession->loggedIn = true;
    $userSession->id = $user->getId();
    $userSession->token = $token;

    Query::setUserToken($user->getId(), Crypter::encrypt($token, 'session'));
    Query::setCookieToken($user->getId(), Crypter::encrypt($cookieToken, 'cookie'));
    Query::updateLastLogin($user->getId());

    $timeout = Registry::get('Options')->get('login_timeout', '10') . ' minutes';
    $userSession->setExpiration($timeout);
    Registry::get('Session')->regenerateId();
  }

  public function isLoggedIn(): bool
  {
    $user = $this->currentUser();

    if (!$user->isValid()) {
      return false;
    }

    $userSession = Registry::get('Session')->getSection('User');
    $userCookie =  $this->request->getCookie('user');

    if (null === $userCookie || null === $userSession->token) {
      return false;
    }

    //Kill user session after n minutes of inactivity
    $timeout = Registry::get('Options')->get('login_timeout', '10') . ' minutes';
    $userSession->setExpiration($timeout);
    Registry::get('Session')->regenerateId();

    return $user->checkSessionToken($userSession->token) && $user->checkCookieToken($userCookie);
  }

  public function signOut(): void
  {
    $this->response->setCookie('user', '', '100 days', '/', null, true, true);
    Registry::get('Session')->getSection('User')->remove();
    Registry::get('Session')->destroy();
  }

  public function getRoles(): array
  {
    if (!empty($this->roles)) {
      return $this->roles;
    }

    $dbRoles = Query::getRoles();

    $this->roles = [];
    foreach ($dbRoles as $key => $role) {
      $permissions = [];
      $json = json_decode($role['role_permissions'], true);

      if (array_key_exists('permissions', $json)) {
        $permissions = array_map(fn ($permission) => $permission, $json['permissions']);
      }

      $this->roles[] = [
        'id' => (int)$role['role_id'],
        'name' => $role['role_name'],
        'permissions' => $permissions
      ];
    }

    return $this->roles;
  }

  public function hasPermission(string $permission): bool
  {
    $user = $this->currentUser();

    if (!$user->isValid()) {
      return false;
    }

    $roles = $this->getRoles();
    $userRole = $user->getRole();

    if (!isset($roles[$userRole - 1])) {
      return false;
    }

    return in_array($permission, $roles[$userRole - 1]['permissions']);
  }
}
