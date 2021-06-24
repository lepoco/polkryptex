<?php

/**
 * @package   Polkryptex
 *
 * @copyright Copyright (c) 2021 - Kacper J., Pawel L., Filip S., Szymon K., Leszek P.
 * @license   https://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace App\Core;

use Nette\Http\Request;
use App\Core\Components\Utils;

/**
 * @author Leszek P.
 */
class Controller extends Blade
{
    protected Request $request;

    protected bool $fullScreen = false;

    protected ?string $name;

    protected ?string $namespace;

    protected ?string $displayName;

    protected ?string $baseUrl;

    protected array $bodyClasses = [];

    protected array $scripts = [];

    protected array $styles = [];

    public function __construct(string $namespace, array $arguments = [])
    {
        $this->request = Registry::get('Request');

        $this->setupNamespace($namespace);
        $this->setupController();
        $this->setupArguments($arguments);

        if (method_exists($this, 'init')) {
            $this->{'init'}();
        }

        $this->print();

        if (method_exists($this, 'done')) {
            $this->{'done'}();
        }

        \App\Core\Application::stop();
    }

    private function setupNamespace(string $namespace): void
    {
        $this->namespace = $namespace;
        $this->name = strtolower(str_replace('\\', '-', $namespace));
        $this->viewData['title'] = $this->name;

        $this->setViewName(Utils::namespaceToTitle($namespace));
        $this->setViewPath(Utils::namespaceToBlade($namespace));
    }

    private function setupArguments(array $arguments): void
    {
        if (isset($arguments['requireLogin']) && true === $arguments['requireLogin']) {
            if (!Registry::get('Account')->isLoggedIn()) {
                $this->redirect('signin');
            }
        }

        if (isset($arguments['title'])) {
            $this->setTitle($arguments['title']);
        }

        if (isset($arguments['fullscreen']) && true === $arguments['fullscreen']) {
            $this->fullScreen = true;
        }
    }

    private function setupController(): void
    {
        parent::__construct();
        $this->baseUrl = $this->getOption('baseurl', ($this->request->isSecured() ? 'https://' : 'http://') . $this->request->url->host . '/');

        $this->registerTranslation();
        $this->registerCoreScripts();
        $this->setDefaultClasses();
    }

    protected function print(): void
    {
        $this->setDefaultViewData();
        $this->bladePrint();
    }

    private function registerTranslation(): void
    {
        $this->addData('language', $this->getOption('language', 'en'));
        $this->addData('noTranslate', false);
    }

    private function registerCoreScripts(): void
    {
        $this->queueInternalScript('app.min');
        $this->queueInternalStyle('main.min');

        $this->registerPageScript();
    }

    private function registerPageScript(): void
    {
        if (is_file(ABSPATH . 'public/js/pages/' . $this->name . '.js')) {
            $this->queueInternalScript('pages/' . $this->name);
        }
    }

    private function setDefaultClasses(): void
    {
        $this->addBodyClass('polkryptex');
        $this->addBodyClass('theme-light');
        $this->addBodyClass('page-' . ($this->fullScreen ? 'fullscreen' : 'regular'));
        $this->addBodyClass('page-' . strtolower($this->name));
    }

    protected function setDefaultViewData(): void
    {
        $this->addData('installed', defined('APP_VERSION'), false);
        $this->addData('pagenow', strtolower($this->name));
        $this->addData('debug', Debug::isDebug());
        $this->addData('baseUrl', $this->baseUrl);
        $this->addData('dashPath', $this->getOption('dashboard', 'dashboard'));
        $this->addData('dashboard', $this->getOption('dashboard', 'dashboard'));
        $this->addData('ajax', $this->baseUrl . 'request/');
        $this->addData('bodyClasses', $this->bodyClasses);
        $this->addData('styles', $this->styles, false);
        $this->addData('scripts', $this->scripts, false);
        $this->addData('fullscreen', $this->fullScreen);
        $this->addData('csrfToken', \App\Core\Components\Crypter::salter(64), false);

        $this->addData('auth', [
            'loggedIn' => Registry::get('Account')->isLoggedIn(),
            'user' => Registry::get('Account')->currentUser()->getId(),
            'email' => Registry::get('Account')->currentUser()->getEmail()
        ], false);

        $this->addData('importmap', [
            'imports' => [
                'js-cookie' => 'https://cdn.jsdelivr.net/npm/js-cookie@rc/dist/js.cookie.min.mjs',
                'popperjs' => 'https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js',
                'bootstrap' => 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.esm.js'
            ]
        ], false);

        $this->addData('props', $this->vueProps);
    }

    protected function queueScript(string $url, ?string $sri = null, ?string $version = null, ?string $type = "text/javascript"): void
    {
        $this->scripts[] = [
            'src'  => $url . ($version != null ? '?v=' . $version : ''),
            'sri'  => $sri,
            'type' => $type
        ];
    }

    protected function queueInternalScript(string $path): void
    {
        $this->queueScript($this->baseUrl . 'js/' . $path . '.js', null, $this->getAppVersion(), 'module');
    }

    protected function queueStyle(string $url, ?string $sri = null, ?string $version = null): void
    {
        $this->styles[] = [
            'src' => $url . ($version != null ? '?v=' . $version : ''),
            'sri' => $sri
        ];
    }

    protected function queueInternalStyle(string $path): void
    {
        $this->queueStyle($this->baseUrl . 'css/' . $path . '.css', null, $this->getAppVersion());
    }

    protected function addBodyClass(string $class): void
    {
        $this->bodyClasses[] = $class;
    }

    protected function setTitle($title): void
    {
        $this->viewData['title'] = $this->__($title);
    }

    protected function setAsFullScreen(): void
    {
        $this->fullScreen = true;
    }

    protected function redirect(?string $path = null): void
    {
        Registry::get('Response')->redirect($this->baseUrl . $path);
    }

    protected function getAppVersion(): string
    {
        if(defined('APP_VERSION')) {
            return APP_VERSION;
        }

        return '0.0.0';
    }

    protected function getOption(string $name, $default = null)
    {
        return \App\Core\Registry::get('Options')->get($name, $default);
    }

    protected function __(string $text, ?array $variables = null): ?string
    {
        return \App\Core\Registry::get('Translator')->translate($text, $variables);
    }
}
