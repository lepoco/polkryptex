<?php

/**
 * @package   Polkryptex
 *
 * @copyright Copyright (c) 2021 - Kacper J., Pawel L., Filip S., Szymon K., Leszek P.
 * @license   https://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace Polkryptex\Controllers;

use Polkryptex\Core\Singleton as App;
use Polkryptex\Common\Http;

/**
 * @author Leszek P.
 */
class Controller
{
    protected ?string $name;

    protected ?string $baseurl;

    protected array $scripts = [];

    protected array $styles = [];

    public function __construct()
    {
        $this->name = App::get()->variables->get('pagenow');

        $this->addDefaultScripts();

        if(get_parent_class($this) == null)
        {
            $this->print();
        }
    }

    private function addDefaultScripts()
    {
        $this->queueScript(App::get()->variables->get('debug')? 'https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js' : 'https://cdn.jsdelivr.net/npm/vue@2');
        $this->queueScript('https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js', 'sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=', '3.6.0');
        $this->queueScript('https://cdn.jsdelivr.net/npm/zxcvbn@4.4.2/dist/zxcvbn.js', 'sha256-9CxlH0BQastrZiSQ8zjdR6WVHTMSA5xKuP5QkEhPNRo=', '4.4.2');
        $this->queueScript('https://cdn.jsdelivr.net/npm/clipboard@2.0.8/dist/clipboard.min.js', 'sha256-Eb6SfNpZyLYBnrvqg4KFxb6vIRg+pLg9vU5Pv5QTzko=', '2.0.8');
        $this->queueScript('https://cdn.jsdelivr.net/npm/chart.js@3.1.1/dist/chart.min.js', 'sha256-lISRn4x2bHaafBiAb0H5C7mqJli7N0SH+vrapxjIz3k=', '3.1.1');

        $this->queueScript(Http::baseUrl('js/main.js'), null, App::get()->variables->get('version'));
        $this->queueStyle(Http::baseUrl('css/main.min.css'), null, App::get()->variables->get('version'));
    }

    protected function getComponent(string $name): void
    {
        if (is_file(ABSPATH . APPDIR . 'views/components/' . $name . '.php')) {
            require_once ABSPATH . APPDIR . 'views/components/' . $name . '.php';
        } else {
            App::get()->debug->exception('Component "' . $name . '" not found!');
        }
    }

    protected function print(): void
    {
        if (is_file(ABSPATH . APPDIR . 'views/' . $this->name . '.php')) {
            require_once ABSPATH . APPDIR . 'views/' . $this->name . '.php';
        } else {
            App::get()->debug->exception('Page not found - ' . $this->name);
        }

        exit;
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
}
