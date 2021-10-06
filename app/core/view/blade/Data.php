<?php

namespace App\Core\View\Blade;

use App\Core\Utils\Cast;
use App\Core\Facades\{Config, Option, Request};

/**
 * Container of information passed to blade views.
 * 
 * @since 1.0.0
 * @author Pomianowski
 * @license https://www.gnu.org/licenses/gpl-3.0.txt
 */
final class Data
{
  private array $data = [];

  public function __construct()
  {
    $this->setDefault();
  }

  public function get(): array
  {
    return $this->data;
  }

  public function set(string $key, $value): self
  {
    $this->data[$key] = $value;

    return $this;
  }

  public function append(string $keys, $value): self
  {
    $keysArray = explode('.', $keys);
    $keysCount = count($keysArray);

    switch ($keysCount) {
      case 1:
        $this->data[$keysArray[0]] = $value;
        break;

      case 2:
        $this->data[$keysArray[0]][$keysArray[1]] = $value;
        break;

      case 3:
        $this->data[$keysArray[0]][$keysArray[1]][$keysArray[2]] = $value;
        break;

      case 4:
        $this->data[$keysArray[0]][$keysArray[1]][$keysArray[2]][$keysArray[3]] = $value;
        break;
    }

    return $this;
  }

  private function setDefault(): void
  {
    $defaultUrl = rtrim(Option::get('base_url', Request::root()), '/') . '/';

    $this->set('version', Config::get('app.version', '0.0.0'));

    $this->set('debug', Config::get('app.debug', true));

    $this->set('base_url', $defaultUrl);

    $this->set('import_map', [
      'imports' => [
        'js-cookie' => 'https://cdn.jsdelivr.net/npm/js-cookie@rc/dist/js.cookie.min.mjs',
        'popperjs' => 'https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js',
        'bootstrap' => 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.esm.js'
      ]
    ]);

    $this->set('styles', [
      [
        'src' => $defaultUrl . 'assets/css/app.min.css',
        'sri' => ''
      ]
    ]);

    $this->set('scripts', [
      [
        'src'  => $defaultUrl . 'assets/js/app.js',
        'sri'  => '',
        'type' => 'module'
      ]
    ]);

    $this->set('js_data', [
      'props' => [
        'baseUrl' => $defaultUrl,
        'ajax' => $defaultUrl . 'request/',
        'dashboard' => 'dashboard',
        'secured' => true,
        'debug' => true,
        'loginTimeout' => 2000,
        'version' => Config::get('app.version', '0.0.0')
      ],
      'auth' => [
        'loggedIn' => false
      ]
    ]);
  }
}
