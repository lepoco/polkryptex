<?php

namespace App\Common\Requests;

use App\Core\View\Request;
use App\Core\Http\Status;
use App\Core\Auth\{Account, User};

/**
 * Action triggered during searching for user.
 *
 * @author  Kujawski <szymon@polkryptex.pl>
 * @license GPL-3.0 h ttps://www.gnu.org/licenses/gpl-3.0.txt
 * @since   1.1.0
 */
final class FindUserRequest extends Request implements \App\Core\Schema\Request
{
  public function getAction(): string
  {
    return 'FindUser';
  }

  public function process(): void
  {
    $this->isSet([
      'id',
      'phrase'
    ]);

    $this->isEmpty([
      'id',
      'phrase'
    ]);

    $this->validate([
      ['id', self::SANITIZE_STRING],
      ['phrase', self::SANITIZE_STRING]
    ]);

    $user = Account::current();

    if (empty($user)) {
      $this->finish(self::ERROR_VALUE_INVALID, Status::UNAUTHORIZED);

      return;
    }

    if ((int)trim($this->get('id')) !== $user->getId()) {
      $this->finish(self::ERROR_VALUE_INVALID, Status::UNAUTHORIZED);

      return;
    }

    $userToFind = strtolower(str_replace(['&lt;', '&gt;'], ['', ''], $this->get('phrase')));
    $userToFind = preg_replace("/[^a-z0-9_+. @]/", '', $userToFind);

    $foundUser = $this->tryFindUser($userToFind);

    if ($foundUser === null) {
      $this->finish(self::ERROR_VALUE_INVALID, Status::UNAUTHORIZED);

      return;
    }

    if ($user->getId() == $foundUser->getId()) {
      $this->finish(self::ERROR_VALUE_INVALID, Status::UNAUTHORIZED);

      return;
    }

    $this->addContent('user_name', $foundUser->getName());
    $this->addContent('user_display_name', $foundUser->getDisplayName());
    $this->addContent('user_image', !empty($foundUser->getImage(false)) ? $foundUser->getImage(true) : '');

    $this->finish(self::CODE_SUCCESS, Status::OK);
  }

  private function tryFindUser(string $phrase): ?User
  {
    $userByName = Account::getLike('name', $phrase);

    if ($userByName !== null) {
      return $userByName;
    }

    $userByEmail = Account::getLike('email', $phrase);

    if ($userByEmail !== null) {
      return $userByEmail;
    }

    $userByDisplayName = Account::getLike('display_name', $phrase);

    if ($userByDisplayName !== null) {
      return $userByDisplayName;
    }

    return null;
  }
}
