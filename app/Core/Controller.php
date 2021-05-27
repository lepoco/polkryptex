<?php

/**
 * @package   Polkryptex
 *
 * @copyright Copyright (c) 2021 - Kacper J., Pawel L., Filip S., Szymon K., Leszek P.
 * @license   https://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace Polkryptex\Core;

use ReflectionMethod;
use Jenssegers\Blade\Blade;

/**
 * @author Leszek P.
 */
class Controller
{
    private Blade $blade;

    private Translator $translator;

    protected const VIEWS_PATH = 'common\\views\\';

    protected ?string $name;

    protected ?string $displayName;

    protected ?string $baseUrl;

    protected bool $fullScreen = false;

    protected array $viewData = [];

    protected array $vueProps = [];

    protected array $variables = [];

    protected array $bodyClasses = [];

    protected array $scripts = [];

    protected array $styles = [];

    public function __construct(string $pageName)
    {
        $this->name = $pageName;
        $this->viewData['title'] = $this->name;

        $this->blade = new Blade(ABSPATH . APPDIR . self::VIEWS_PATH, ABSPATH . APPDIR . 'cache\\');

        if (method_exists($this, 'init')) {
            $this->{'init'}();
        }

        $this->print();

        if (method_exists($this, 'done')) {
            $this->{'done'}();
        }

        exit;
    }

    private function setDefaultClasses()
    {
        $this->addBodyClass('polkryptex');
        $this->addBodyClass('theme-light');
        $this->addBodyClass('page-' . ($this->fullScreen ? 'fullscreen' : 'regular'));
        $this->addBodyClass('page-' . strtolower($this->name));
    }

    protected function addData(string $name, $data, bool $prop = true)
    {
        $this->viewData[$name] = $data;

        if($prop)
        {
            $this->vueProps[$name] = $data;
        }
    }

    protected function setDefaultViewData()
    {
        $this->addData('body_classes', implode(' ', $this->bodyClasses));
        $this->addData('styles', $this->styles, false);
        $this->addData('scripts', $this->scripts, false);

        $this->addData('language', 'en');
        $this->addData('fullscreen', $this->fullScreen);

        $this->addData('csrf_token','abcdefg', false);
        
        $this->addData('auth', [
            'user' => ''
        ], false);
        
        $this->addData('importmap', [
            'imports' => [
                'vue' => 'https://unpkg.com/vue@3.0.11/dist/vue.esm-browser.js',
                'vue-router' => 'https://unpkg.com/vue-router@4.0.5/dist/vue-router.esm-browser.js',
                'html' => '/js/html.js'
            ]
        ], false);

        $this->addData('props', $this->vueProps);
    }

    protected function setPublicFunctions()
    {
        $methods = get_class_methods($this);

        foreach ($methods as $method) {
            $reflect = new ReflectionMethod($this, $method);
            if ($reflect->isPublic() && $reflect->isStatic() && strpos($method, '__') === false) {
                $this->addData($this->pascalToKebab($method, '_'), $this->{$method}());
            }
        }
    }

    protected function print(): void
    {
        $this->queueScript('js/app.min.js', null, $this->getVariable('version'), 'module');
        $this->queueStyle('css/main.min.css', null, $this->getVariable('version'));

        $this->setDefaultClasses();

        $this->setDefaultViewData();
        $this->setPublicFunctions();

        $pagename = $this->pascalToKebab($this->name);
        if ($this->getVariable('debug')) {
            $this->blade->make($pagename, $this->viewData);
        }

        echo $this->blade->render($pagename, $this->viewData);
    }

    protected function addDirective(string $name, $directive)
    {
        $this->blade->directive($name, $directive);
    }

    protected function getVariable(string $name, bool $update = false)
    {
        if (empty($this->variables) || $update) {
            $this->variables = Registry::get('Variables')->getAll();
        }

        return $this->variables[$name] ?? null;
    }

    protected function pascalToKebab(string $input, string $separator = '-'): string
    {
        preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $input, $matches);
        $ret = $matches[0];
        foreach ($ret as &$match) {
            $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
        }
        return implode($separator, $ret);
    }

    protected function addBodyClass(string $class): void
    {
        $this->bodyClasses[] = $class;
    }

    protected function setTitle($title)
    {
        $this->viewData['title'] = $title;
    }

    protected function setAsFullScreen(): void
    {
        $this->fullScreen = true;
    }

    protected function queueScript(string $url, ?string $sri = null, ?string $version = null, ?string $type = "text/javascript")
    {
        $this->scripts[] = [
            'src'  => $url . ($version != null ? '?v=' . $version : ''),
            'sri'  => $sri,
            'type' => $type
        ];
    }

    protected function queueStyle(string $url, ?string $sri = null, ?string $version = null)
    {
        $this->styles[] = [
            'src' => $url . ($version != null ? '?v=' . $version : ''),
            'sri' => $sri
        ];
    }

    public function __(string $text, ?array $variables = null): ?string
    {
        return Registry::get('Translator')->trans($text, $variables);
    }
}
