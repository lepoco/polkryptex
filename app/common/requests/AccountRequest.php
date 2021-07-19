<?php

/**
 * @package   Polkryptex
 *
 * @copyright Copyright (c) 2021 - Kacper J., Pawel L., Filip S., Szymon K., Leszek P.
 * @license   https://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace App\Common\Requests;

use App\Core\Registry;
use App\Core\Request;
use App\Core\Components\Query;
use App\Core\Components\Crypter;

/**
 * @author Leszek P.
 */
final class AccountRequest extends Request
{
  public function action(): void
  {
    $this->isSet([
      'id',
      'displayname'
    ]);

    $this->isEmpty([
      'id',
      'displayname'
    ]);

    $this->validate([
      ['id', FILTER_SANITIZE_NUMBER_INT],
      ['displayname', FILTER_SANITIZE_STRING]
    ]);

    $user = Registry::get('Account')->currentUser();

    if ($user->getId() != $this->getData('id')) {
      $this->addContent('message', $this->translate('User is invalid.'));

      $this->finish(self::ERROR_INVALID_USER);
    }

    if ($user->getDisplayName() != $this->getData('displayname')) {
      Query::updateUserDisplayName($user->getId(), $this->getData('displayname'));
    }

    /**
     * @var \Nette\Http\FileUpload
     */
    $profilePicture = $this->request->getFile('picture');

    if (null !== $profilePicture) {

      if (!($profilePicture->isOk() && $profilePicture->isImage())) {
        $this->finish(self::CODE_SUCCESS);
      }
      // var_dump($profilePicture->getUntrustedName());
      // var_dump($profilePicture->getContentType());
      // var_dump($profilePicture->getSize());
      // var_dump($profilePicture->getTemporaryFile());
      // var_dump($profilePicture->isOk());
      // var_dump($profilePicture->isOk());
      // var_dump($profilePicture->isImage());
      // var_dump($profilePicture->getImageFileExtension());

      $pictureName = $user->getUUID() . '-' . Crypter::salter(32, 'LN');
      $pictureNameExt = $pictureName . '.' . $profilePicture->getImageFileExtension();
      $pictureNameCompressed = $pictureName . '-300x300' . '.jpg';

      $imagePath = $this->getImagePath($pictureNameExt);
      $imageUrl = $this->getImageUrl($pictureNameCompressed);

      $profilePicture->move($imagePath);
      $this->compressImage($imagePath, $this->getImagePath($pictureNameCompressed), 300, 300, false, true);

      Query::updateUserImage($user->getId(), $pictureNameCompressed);
      $this->addContent('picture', $imageUrl);
    }

    $this->addContent('message', $this->translate('Your account details have been successfully updated.'));
    $this->finish(self::CODE_SUCCESS);
  }

  /**
   * @see https://www.php.net/manual/en/function.imagejpeg.php
   * @see https://www.php.net/manual/en/function.imagescale.php
   */
  private function compressImage(string $sourcePath, string $destinationPath, int $inputWidth, int $inputHeight, bool $crop = false, bool $removeSource = false): bool
  {
    list($width, $height) = getimagesize($sourcePath);
    $r = $width / $height;

    $info = getimagesize($sourcePath);

    if ($info['mime'] == 'image/jpeg') {
      $sourceImage = imagecreatefromjpeg($sourcePath);
    } elseif ($info['mime'] == 'image/gif') {
      $sourceImage = imagecreatefromgif($sourcePath);
    } elseif ($info['mime'] == 'image/png') {
      $sourceImage = imagecreatefrompng($sourcePath);
    }

    if ($crop) {
      if ($width > $height) {
        $width = ceil($width - ($width * abs($r - $inputWidth / $inputHeight)));
      } else {
        $height = ceil($height - ($height * abs($r - $inputWidth / $inputHeight)));
      }
      $newWidth = $inputWidth;
      $newHeight = $inputHeight;
    } else {
      if ($inputWidth / $inputHeight > $r) {
        $newWidth = $inputHeight * $r;
        $newHeight = $inputHeight;
      } else {
        $newHeight = $inputWidth / $r;
        $newWidth = $inputWidth;
      }
    }

    $destinationImage = imagecreatetruecolor($newWidth, $newHeight);
    imagecopyresampled($destinationImage, $sourceImage, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

    imagejpeg($destinationImage, $destinationPath);

    if ($removeSource) {
      unlink($sourcePath);
    }

    return true;
  }

  private function getImageUrl(string $name): string
  {
    $baseUrl = Registry::get('Options')->get('baseurl', ($this->request->isSecured() ? 'https://' : 'http://') . $this->request->url->host . '/');
    return $baseUrl . APP_UPLOADS . $name;
  }

  private function getImagePath(string $name): string
  {
    return ABSPATH . 'public/' . APP_UPLOADS . $name;
  }
}
