<?php

/**
 * @package   Polkryptex
 *
 * @copyright Copyright (c) 2021 - Kacper J., Pawel L., Filip S., Szymon K., Leszek P.
 * @license   https://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace App\Core;

use ReflectionMethod;

/**
 * @author Leszek P.
 */
abstract class Blade
{
    protected const COMPOSERS_NAMESPACE = '\\App\\Common\\Composers\\';

    protected const VIEWS_PATH = 'common\\views\\';

    protected const CACHE_PATH = 'cache\\';

    protected ?\Jenssegers\Blade\Blade $blade = null;

    protected string $viewTitle = '';

    protected string $viewPath = '';

    protected array $viewData = [];

    protected array $vueProps = [];

    public function __construct()
    {
        $this->blade = new \Jenssegers\Blade\Blade(ABSPATH . APPDIR . self::VIEWS_PATH, ABSPATH . APPDIR . self::CACHE_PATH);

        $this->registerDirectives();
    }

    protected function setViewName(string $title)
    {
        $this->viewTitle = $title;
    }

    protected function setViewPath(string $path)
    {
        $this->viewPath = $path;
    }

    protected function bladePrint(): void
    {
        if (!$this->blade->exists($this->viewPath)) {
            $this->blade->render('notfound', $this->viewData);
        }

        $composer = self::COMPOSERS_NAMESPACE . $this->viewTitle . 'Composer';

        if (class_exists($composer)) {
            $this->blade->composer($this->viewPath, $composer);
        }

        echo $this->blade->render($this->viewPath, $this->viewData);
    }

    protected function addData(string $name, $data, bool $prop = true)
    {
        $this->viewData[$name] = $data;

        if ($prop) {
            $this->vueProps[$name] = $data;
        }
    }

    protected function addDirective(string $name, $directive)
    {
        $this->blade->directive($name, $directive);
    }

    protected function registerDirectives()
    {
        $this->addDirective('translate', function ($text) {
            return '<?php echo App\Core\Registry::get(\'Translator\')->translate(' . $text . '); ?>';
        });

        $this->addDirective('option', function ($name, $default = null) {
            return '<?php echo App\Core\Registry::get(\'Options\')->get(' . $name . ', ' . $default . '); ?>';
        });

        $this->addDirective('nonce', function ($action) {
            return '<?php echo App\Core\Components\Crypter::encrypt(\'ajax_' . str_replace('\'', '', $action) . '_nonce\', \'nonce\'); ?>';
        });

        $this->addDirective('media', function ($media) {
            return '<?php echo $baseUrl . \'media/' . str_replace('\'', '', $media) . '\'; ?>';
        });

        $this->addDirective('debug', function () {
            return '<?php dump(get_defined_vars()); ?>';
        });

        $this->addDirective('placeholder', function ($size = '100', $text = 'POLKRYPTEX') {

            $size = str_replace('\'', '', $size);
            $text = str_replace('\'', '', $text);

            if (strpos($size, 'x') === false) {
                $width = $height = intval($size);
            } else {
                $size = explode('x', $size);
                $width = intval($size[0]);
                $height = intval($size[1]);
            }

            $textH = $width / 10;
            $textX = $width / 2 - (($textH / 1.5) * strlen($text) / 2);
            $textY = $height / 2 + ($textH / 2);

            $svg = '<svg version="1.1" width="' . $width . '" height="' . $height . '" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 ' . $width . ' ' . $height . '" xml:space="preserve">';
            $svg .= '<rect fill="#000" width="' . $width . '" height="' . $height . '"/>';
            $svg .= '<text fill="#FFF" font-size="' . $textH . 'px" font-weight="bold" font-family="Raleway, Helvetica, sans-serif" transform="matrix(1 0 0 1 ' . $textX . ' ' . $textY . ')">' . $text . '</text></svg>';

            return '<?php echo \'' . $svg . '\'; ?>';
        });
    }
}
