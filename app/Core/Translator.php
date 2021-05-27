<?php

/**
 * @package   Polkryptex
 *
 * @copyright Copyright (c) 2021 - Kacper J., Pawel L., Filip S., Szymon K., Leszek P.
 * @license   https://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace Polkryptex\Core;

use Symfony\Component\Translation\Translator as SymfonyTranslator;
use Symfony\Component\Translation\Loader\ArrayLoader;

/**
 * @author Leszek P.
 */
final class Translator
{
    protected SymfonyTranslator $symfonyTranslator;
    protected array $cache = [];

    public function __construct()
    {
        //$this->setLanguage();
    }

    public function setLanguage(string $code = 'en_US')
    {
        $this->symfonyTranslator = new Translator('fr_FR');
    }

    public function trans(): ?string
    {
        return null;
    }
}
