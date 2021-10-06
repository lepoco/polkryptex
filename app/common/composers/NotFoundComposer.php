<?php

/**
 * @package Polkryptex
 * @license https://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace App\Common\Composers;

use App\Core\View\Blade\Composer;
use Illuminate\View\View;

/**
 * Abstraction for the request, contains the necessary underlying methods.
 *
 * @author  Pomianowski <kontakt@rapiddev.pl>
 * @license GPL-3.0 https://www.gnu.org/licenses/gpl-3.0.txt
 * @since   1.0.0
 */
final class NotFoundComposer extends Composer implements \App\Core\Schema\Composer
{
  public function compose(View $view): void
  {
    $this->setResponseCode(\App\Core\View\Renderable::STATUS_NOT_FOUND);
  }
}
