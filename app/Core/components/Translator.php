<?php

/**
 * @package   Polkryptex
 *
 * @copyright Copyright (c) 2021 - Kacper J., Pawel L., Filip S., Szymon K., Leszek P.
 * @license   https://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace Polkryptex\Core\Components;

use Symfony\Component\Translation\Translator as SymfonyTranslator;
use Symfony\Component\Translation\Loader\MoFileLoader;

/**
 * @author Leszek P.
 */
final class Translator
{

    protected const DEFAULT_LANGUAGE = 'en_US';

    protected ?SymfonyTranslator $symfonyTranslator = null;

    public function setLanguage(string $code = null): void
    {
        if ($code == null) {
            $code = self::DEFAULT_LANGUAGE;
        }

        if ($this->symfonyTranslator == null) {
            $this->symfonyTranslator = new SymfonyTranslator($code);
            $this->symfonyTranslator->addLoader('mo', new MoFileLoader());
        }

        $moFile = ABSPATH . 'app/common/languages/' . $code . '.mo';
        if (is_file($moFile)) {
            $this->symfonyTranslator->addResource('mo', $moFile, $code);

            return;
        }

        if ($code != 'en_US') {
            \Polkryptex\Core\Registry::get('Debug')->exception('The "' . $moFile . '" translation file for the ' . $code . ' language could not be found.');
        }
    }

    public function translate(string $text, $variables = null): ?string
    {
        if ($this->symfonyTranslator == null) {
            $this->symfonyTranslator = new SymfonyTranslator(self::DEFAULT_LANGUAGE);
            $this->symfonyTranslator->addLoader('mo', new MoFileLoader());
        }

        return $this->symfonyTranslator->trans($text);
    }
}
