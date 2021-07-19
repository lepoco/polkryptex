<?php

/**
 * @package   Polkryptex
 *
 * @copyright Copyright (c) 2021 - Kacper J., Pawel L., Filip S., Szymon K., Leszek P.
 * @license   https://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace App\Core;

/**
 * @author Leszek P.
 */
abstract class Renderable
{
  public function __construct()
  {
    $this->__prepare();
  }

  private function __prepare()
  {
    header_remove('X-Powered-By');
    header_remove('Expires');
    header_remove('Pragma');
    header_remove('Cache-Control');
    header('Cache-Control: max-age=0, immutable');
    header('Content-Type: text/html; charset=UTF-8');
    header('X-Content-Type-Options: nosniff');
  }
}
