<?php

/**
 * @package   Polkryptex
 *
 * @copyright Copyright (c) 2021 - Kacper J., Pawel L., Filip S., Szymon K., Leszek P.
 * @license   https://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace Polkryptex\Common\Requests;

use Polkryptex\Core\Registry;
use Polkryptex\Core\Request;
use Polkryptex\Core\Components\Query;
use Polkryptex\Core\Components\User;
use Polkryptex\Core\Components\Crypter;

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

            $salt = Crypter::salter(16, 'ULN');
            $imagePath = $this->getImagePath($user->getUUID() . $salt . '.' . $profilePicture->getImageFileExtension());
            $imageUrl = $this->getImageUrl($user->getUUID() . $salt  . '.' . $profilePicture->getImageFileExtension());

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
}
