<?php

/**
 * @package   Polkryptex
 *
 * @copyright Copyright (c) 2021 - Kacper J., Pawel L., Filip S., Szymon K., Leszek P.
 * @license   https://www.gnu.org/licenses/gpl-3.0.txt
 */

//declare(strict_types=1);

namespace App\Core\Authentication;

use Webauthn\PublicKeyCredentialSourceRepository as PublicKeyCredentialSourceRepositoryInterface;
use Webauthn\PublicKeyCredentialSource;
use Webauthn\PublicKeyCredentialUserEntity;

/**
 * @license The MIT License (MIT)
 * @copyright Copyright (c) 2014-2019 Spomky-Labs
 * @see https://webauthn-doc.spomky-labs.com/pre-requisites/credential-source-repository
 */
final class PublicKeyCredentialSourceRepository implements PublicKeyCredentialSourceRepositoryInterface
{
  private string $path = '';

  public function setPath(string $path): void
  {
    $this->path = $path;
  }

  public function findOneByCredentialId(string $publicKeyCredentialId): ?PublicKeyCredentialSource
  {
    $data = $this->read();
    if (isset($data[base64_encode($publicKeyCredentialId)])) {
      return PublicKeyCredentialSource::createFromArray($data[base64_encode($publicKeyCredentialId)]);
    }
    return null;
  }

  /**
   * @return PublicKeyCredentialSource[]
   */
  public function findAllForUserEntity(PublicKeyCredentialUserEntity $publicKeyCredentialUserEntity): array
  {
    $sources = [];
    foreach ($this->read() as $data) {
      $source = PublicKeyCredentialSource::createFromArray($data);
      if ($source->getUserHandle() === $publicKeyCredentialUserEntity->getId()) {
        $sources[] = $source;
      }
    }
    return $sources;
  }

  public function saveCredentialSource(PublicKeyCredentialSource $publicKeyCredentialSource): void
  {
    $data = $this->read();
    $data[base64_encode($publicKeyCredentialSource->getPublicKeyCredentialId())] = $publicKeyCredentialSource;
    $this->write($data);
  }

  private function read(): array
  {
    if (file_exists($this->path)) {
      return json_decode(file_get_contents($this->path), true);
    }
    return [];
  }

  private function write(array $data): void
  {
    if (!file_exists($this->path)) {
      if (!mkdir($concurrentDirectory = dirname($this->path), 0700, true) && !is_dir($concurrentDirectory)) {
        throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
      }
    }
    file_put_contents($this->path, json_encode($data), LOCK_EX);
  }
}
