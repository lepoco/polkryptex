<?php

namespace App\Core\Factories;

use App\Core\View\Controller;

/**
 * Views controller factory.
 *
 * @author  Pomianowski <support@polkryptex.pl>
 * @license GPL-3.0 https://www.gnu.org/licenses/gpl-3.0.txt
 * @since   1.1.0
 */
final class ControllerFactory implements \App\Core\Schema\Factory
{
  /**
   * @return \App\Core\Schema\Controller
   */
  public static function make(string $property = '')
  {
    return (new Controller())->setNamespace($property);
  }
}
