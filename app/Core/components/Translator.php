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

    protected const DEFAULT_LANGUAGE = 'en_US';

    protected static ?SymfonyTranslator $symfonyTranslator = null;

    public static function init()
    {
        $translator = new self();
        Registry::register('Translator', $translator);
    }

    public static function setLanguage(string $code = null)
    {
        if($code == null)
        {
            $code = self::DEFAULT_LANGUAGE;
        }

        if (self::$symfonyTranslator == null) {
            self::$symfonyTranslator = new SymfonyTranslator($code);
            self::$symfonyTranslator->addLoader('mo', new MoFileLoader());
        }

        $moFile = ABSPATH . 'app/common/languages/' . $code . '.mo';
        if (is_file($moFile)) {
            self::$symfonyTranslator->addResource('mo', $moFile, $code);
        } else {
            Registry::get('Debug')->exception('The "' . $moFile . '" translation file for the ' . $code . ' language could not be found.');
        }
    }

    public static function translate(string $text): ?string
    {
        if(self::$symfonyTranslator == null)
        {
            self::$symfonyTranslator = new SymfonyTranslator(self::DEFAULT_LANGUAGE);
            self::$symfonyTranslator->addLoader('mo', new MoFileLoader());
        }

        return self::$symfonyTranslator->trans($text);
    }
}
