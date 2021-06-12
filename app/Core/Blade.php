<?php

/**
 * @package   Polkryptex
 *
 * @copyright Copyright (c) 2021 - Kacper J., Pawel L., Filip S., Szymon K., Leszek P.
 * @license   https://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace Polkryptex\Core;

use ReflectionMethod;

/**
 * @author Leszek P.
 */
class Blade
{
    protected const VIEWS_PATH = 'common\\views\\';

    protected const CACHE_PATH = 'cache\\';

    protected ?\Jenssegers\Blade\Blade $blade = null;

    protected bool $debug;

    protected array $viewData = [];

    protected array $vueProps = [];

    public function __construct()
    {
        $this->blade = new \Jenssegers\Blade\Blade(ABSPATH . APPDIR . self::VIEWS_PATH, ABSPATH . APPDIR . self::CACHE_PATH);
        $this->baseDirectives();
        $this->baseMethods();
    }

    public function isDebug(?bool $debug = null)
    {
        if ($debug === null) {
            return $this->debug;
        }

        $this->debug = $debug;
    }

    public function bladePrint(string $name): void
    {
        if ($this->debug) {
            $test = $this->blade->make($name, $this->viewData);
        }

        echo $this->blade->render($name, $this->viewData);
    }

    protected function addData(string $name, $data, bool $prop = true)
    {
        $this->viewData[$name] = $data;

        if ($prop) {
            $this->vueProps[$name] = $data;
        }
    }

    public function addDirective(string $name, $directive)
    {
        $this->blade->directive($name, $directive);
    }

    protected function baseMethods()
    {
        $methods = get_class_methods($this);

        foreach ($methods as $method) {
            $reflect = new ReflectionMethod($this, $method);
            if ($reflect->isPublic() && $reflect->isStatic() && strpos($method, '__') === false) {
                $this->addData($this->pascalToKebab($method, '_'), $this->{$method}());
            }
        }
    }

    protected function baseDirectives()
    {
        $this->addDirective('translate', function ($text) {
            return '<?php echo Polkryptex\Core\Components\Translator::translate(' . $text . '); ?>';
        });

        $this->addDirective('placeholder', function ($size = '100', $text = 'POLKRYPTEX') {

            $size = str_replace('\'', '', $size);
            $text = str_replace('\'', '', $text);

            if(strpos($size, 'x') === false)
            {
                $width = $height = intval($size);
            }
            else
            {
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
