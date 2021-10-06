<?php

namespace App\Core\View;


use App\Core\View\Blade\Factory;
use App\Core\View\Blade\Directives;
use App\Core\Utils\Cast;
use App\Core\Facades\Config;
use Illuminate\Support\Str;

/**
 * Contains global logic for all views. If you want to add data for single view, use Composer.
 * 
 * @since 1.0.0
 * @author Pomianowski
 * @license https://www.gnu.org/licenses/gpl-3.0.txt
 */
final class Controller extends Factory implements \App\Core\Schema\Controller
{
  public function __construct()
  {
    parent::__construct();

    $this
      ->setupBlade()
      ->setupDirectives(new Directives());
  }

  public function print(): self
  {
    $this->controllerData();

    echo $this->render(Cast::namespaceToBlade($this->namespace));

    return $this;
  }

  private function controllerData(): void
  {
    $this->data->set('pagenow', Cast::namespaceToBlade($this->namespace));

    $this->data->set('body_classes', [
      'app',
      Str::lower(Config::get('app.name', 'application')),
      'page-' . Cast::namespaceToBlade($this->namespace)
    ]);

    $this->data->set('auth', [
      'loggedIn' => false
    ]);

    $this->data->append('js_data.props.view', Cast::namespaceToBlade($this->namespace));
  }
}
