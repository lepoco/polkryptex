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
use App\Core\Components\User;
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

            $pictureName = $user->getUUID() . '-' . Crypter::salter(32, 'LN') . '.' . $profilePicture->getImageFileExtension();
            $imagePath = $this->getImagePath($pictureName);
            $imageUrl = $this->getImageUrl($pictureName);

            $profilePicture->move($imagePath);
            Query::updateUserImage($user->getId(), $imageUrl);

            $this->addContent('picture', $imageUrl);
        }

        $this->finish(self::CODE_SUCCESS);
    }

    private function getImageUrl(string $name): string
    {
        $baseUrl = Registry::get('Options')->get('baseurl', ($this->request->isSecured() ? 'https://' : 'http://') . $this->request->url->host . '/');
        return $baseUrl . 'media/uploads/' . $name;
    }

    private function getImagePath(string $name): string
    {
        return ABSPATH . 'public/media/uploads/' . $name;
    }

    /**
     * @see https://www.php.net/manual/en/function.imagejpeg.php
     * @see https://www.php.net/manual/en/function.imagescale.php
     */
    private function compressImage($source, $destination, $quality) {

        $info = getimagesize($source);
      
        if ($info['mime'] == 'image/jpeg') 
          $image = imagecreatefromjpeg($source);
      
        elseif ($info['mime'] == 'image/gif') 
          $image = imagecreatefromgif($source);
      
        elseif ($info['mime'] == 'image/png') 
          $image = imagecreatefrompng($source);
      
        imagejpeg($image, $destination, $quality);
      
      }

      //$img = resize_image(‘/path/to/some/image.jpg’, 200, 200);

      function resize_image($file, $w, $h, $crop=FALSE) {
        list($width, $height) = getimagesize($file);
        $r = $width / $height;
        if ($crop) {
            if ($width > $height) {
                $width = ceil($width-($width*abs($r-$w/$h)));
            } else {
                $height = ceil($height-($height*abs($r-$w/$h)));
            }
            $newwidth = $w;
            $newheight = $h;
        } else {
            if ($w/$h > $r) {
                $newwidth = $h*$r;
                $newheight = $h;
            } else {
                $newheight = $w/$r;
                $newwidth = $w;
            }
        }
        $src = imagecreatefromjpeg($file);
        $dst = imagecreatetruecolor($newwidth, $newheight);
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
    
        return $dst;
    }

    //$image = imagecreatefromjpeg($image_name);
    //$imgResized = imagescale($image , 500, 400); // width=500 and height = 400
    //  $imgResized is our final product
}
