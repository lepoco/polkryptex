<?php

namespace App\Core\Factories;

use App\Core\Facades\Request as IlluminateRequest;
use Illuminate\Support\Str;

/**
 * Global http request factory.
 *
 * @author  Pomianowski <kontakt@rapiddev.pl>
 * @license GPL-3.0 https://www.gnu.org/licenses/gpl-3.0.txt
 * @since   1.1.0
 */
final class RequestFactory implements \App\Core\Schema\Factory
{
  private const NAMESPACE = '\\App\\Common\\Requests\\';

  /**
   * @return \App\Core\Schema\Request
   */
  public static function make(string $property = '')
  {
    if (empty($property) && IlluminateRequest::has('action')) {
      $property = Str::ucfirst(IlluminateRequest::get('action'));
    }

    $requestClass = self::NAMESPACE . $property . 'Request';

    if (!class_exists($requestClass)) {
      self::printBadRequest();

      return;
    }

    return new $requestClass();
  }

  private static function printBadRequest(): void
  {
    http_response_code(404);

    header('Content-Type: application/json; charset=utf-8');

    echo json_encode([
      'status' => 'error',
      'content' => ['message' => 'Bad request - ' . (empty($property) ? 'Empty' : $property)]
    ], JSON_UNESCAPED_UNICODE);
  }
}
