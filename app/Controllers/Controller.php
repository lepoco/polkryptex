<?php

/**
 * @package   Polkryptex
 *
 * @copyright Copyright (c) 2021 - Kacper J., Pawel L., Filip S., Szymon K., Leszek P.
 * @license   https://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace Polkryptex\Controllers;

use Polkryptex\Core\Registry;
use Polkryptex\Common\Http;

/**
 * @author Leszek P.
 */
class Controller
{
    protected ?string $name;

    protected ?string $baseurl;

    protected bool $fullScreen = false;

    protected array $variables = [];

    protected array $bodyClasses = [];

    protected array $scripts = [];

    protected array $styles = [];

    public function __construct()
    {
        $this->name = $this->getVariable('page_now');

        $this->addDefaultClasses();
        $this->addDefaultScripts();

        if (method_exists($this, 'init'))
        {
            $this->{'init'}();
        }

        $this->print();

        if (method_exists($this, 'done')) {
            $this->{'done'}();
        }

        exit;
    }

    private function addDefaultClasses()
    {
        $this->addBodyClass('polkryptex');
        $this->addBodyClass('theme-light');
        $this->addBodyClass('page-' . ($this->fullScreen ? 'fullscreen' : 'regular'));
        $this->addBodyClass('page-' . strtolower($this->name));
    }

    private function addDefaultScripts()
    {
        $this->queueScript($this->getVariable('debug') ? 'https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js' : 'https://cdn.jsdelivr.net/npm/vue@2');
        $this->queueScript('https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js', 'sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=', '3.6.0');
        $this->queueScript('https://cdn.jsdelivr.net/npm/zxcvbn@4.4.2/dist/zxcvbn.js', 'sha256-9CxlH0BQastrZiSQ8zjdR6WVHTMSA5xKuP5QkEhPNRo=', '4.4.2');
        $this->queueScript('https://cdn.jsdelivr.net/npm/clipboard@2.0.8/dist/clipboard.min.js', 'sha256-Eb6SfNpZyLYBnrvqg4KFxb6vIRg+pLg9vU5Pv5QTzko=', '2.0.8');
        $this->queueScript('https://cdn.jsdelivr.net/npm/chart.js@3.1.1/dist/chart.min.js', 'sha256-lISRn4x2bHaafBiAb0H5C7mqJli7N0SH+vrapxjIz3k=', '3.1.1');

        $this->queueScript(Http::baseUrl('js/main.min.js'), null, $this->getVariable('version'));
        $this->queueStyle(Http::baseUrl('css/main.min.css'), null, $this->getVariable('version'));
    }

    protected function addBodyClass(string $class): void
    {
        $this->bodyClasses[] = $class;
    }

    protected function getBodyClasses(): string
    {
        return implode(' ', $this->bodyClasses);
    }

    protected function setAsFullScreen(): void
    {
        $this->fullScreen = true;
    }

    protected function getComponent(string $name): void
    {
        if (is_file(ABSPATH . APPDIR . 'views/components/' . $name . '.php')) {
            require_once ABSPATH . APPDIR . 'views/components/' . $name . '.php';
        } else {
            Registry::get('Debug')->exception('Component "' . $name . '" not found!');
        }
    }

    protected function getVariable(string $name, bool $update = false)
    {
        if(empty($this->variables) || $update)
        {
            $this->variables = Registry::get('Variables')->getAll();
        }

        return $this->variables[$name] ?? null;
    }

    protected function print(): void
    {
        if (is_file(ABSPATH . APPDIR . 'views/' . $this->name . '.php')) {
            require_once ABSPATH . APPDIR . 'views/' . $this->name . '.php';
        } else {
            Registry::get('Debug')->exception('Page not found - ' . $this->name);
        }
    }

    protected function queueScript(string $url, ?string $sri = null, ?string $version = null, ?string $type = "text/javascript")
    {
        $this->scripts[] = [$url . ($version != null ? '?v=' . $version : ''), $sri, $type];
    }

    protected function queueStyle(string $url, ?string $sri = null, ?string $version = null)
    {
        $this->styles[] = [$url . ($version != null ? '?v=' . $version : ''), $sri];
    }

    protected function title(): void
    {
        echo $this->name; // ?
    }

    protected function __(string $text, ?array $variables = null): ?string
    {
        return Registry::get('Translator')->trans($text, $variables);
    }
}
