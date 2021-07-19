<?php

/**
 * @package   Polkryptex
 *
 * @copyright Copyright (c) 2021 - Kacper J., Pawel L., Filip S., Szymon K., Leszek P.
 * @license   https://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace App\Core\Authentication;

use App\Core\Registry;
use App\Core\Components\User;
use Webauthn\Server;
use Webauthn\PublicKeyCredentialUserEntity;
use Webauthn\PublicKeyCredentialRpEntity;

/**
 * @author Leszek P.
 * @see https://webauthn-doc.spomky-labs.com/pre-requisites/the-relaying-party
 */
final class WebAuth
{
  private const WA_APP_NAME = 'Polkryptex';
  private const WA_APP_DEFAULT_DOMAIN = 'polkryptex.pl';
  private const WA_CRED_PATH = 'cert/pub.json';

  private Server $server;

  private PublicKeyCredentialSourceRepository $credRepository;

  private PublicKeyCredentialRpEntity $rpEntity;

  public function __construct()
  {
    $this->rpEntity = new PublicKeyCredentialRpEntity(
      self::WA_APP_NAME, // The application name
      self::getDomain(), // The application ID = the domain
      self::getIcon()    // The application encoded image
    );

    $this->setupRepository();
    $this->setupServer();
  }

  public static function getUserEntity(User $user): PublicKeyCredentialUserEntity
  {
    return new PublicKeyCredentialUserEntity(
      $user->getName(),       // Username
      $user->getUUID(),       // ID
      $user->getDisplayName() // Display name
      //user avatar url
    );
  }

  private function setupRepository(): void
  {
    $this->credRepository = new PublicKeyCredentialSourceRepository();
    $this->credRepository->setPath(self::getPubPath());
  }

  private function setupServer(): void
  {
    // $this->server = new Server(
    //     $this->rpEntity,
    //     $this->credRepository,
    // );
  }

  private static function getPubPath(): string
  {
    return ABSPATH . APPDIR . self::WA_CRED_PATH;
  }

  private static function getDomain(): string
  {
    return Registry::get('Options')->get('host', self::WA_APP_DEFAULT_DOMAIN);
  }

  private static function getIcon(): string
  {
    return 'data:image/png;base64,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';
  }
}
