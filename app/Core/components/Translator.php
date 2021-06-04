<?php

/**
 * @package   Polkryptex
 *
 * @copyright Copyright (c) 2021 - Kacper J., Pawel L., Filip S., Szymon K., Leszek P.
 * @license   https://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace Polkryptex\Core\Components;

use Polkryptex\Core\Registry;
use Symfony\Component\Translation\Translator as SymfonyTranslator;
use Symfony\Component\Translation\Loader\MoFileLoader;

/**
 * @author Leszek P.
 */
final class Translator
{
    protected ?SymfonyTranslator $symfonyTranslator = null;
    
    protected ?string $currentDomain = null;

    public static function init()
    {
        $translator = new self();
        Registry::register('Translator', $translator);
    }

    private function initializeSymfony($code = 'en_US')
    {
        $this->symfonyTranslator = new SymfonyTranslator($code);
        $this->symfonyTranslator->addLoader('mo', new MoFileLoader());
    }

    public function setLanguage(string $code = 'en_US')
    {
        if ($this->symfonyTranslator == null) {
            $this->initializeSymfony($code);
        }

        $moFile = ABSPATH . 'app/common/languages/' . $code . '.mo';
        if (is_file($moFile)) {
            $this->symfonyTranslator->addResource('mo', $moFile, $code);

            $this->currentDomain = $code;
        } else {
            Registry::get('Debug')->exception('The "' . $moFile . '" translation file for the ' . $code . ' language could not be found.');
        }
    }

    public function trans(string $text): ?string
    {
        if($this->symfonyTranslator == null)
        {
            $this->initializeSymfony();
        }

        return $this->symfonyTranslator->trans($text);
    }

    public static function translate(string $string): ?string
    {
        return Registry::get('Translator')->trans($string);
    }
}
