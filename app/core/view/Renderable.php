<?php

namespace App\Core\View;

use App\Core\Facades\Request;

/**
 * Abstraction for a view/request, contains the basic logic for all kinds of returned data in the browser.
 *
 * @since 1.0.0
 * @author Pomianowski
 * @license https://www.gnu.org/licenses/gpl-3.0.txt
 */
abstract class Renderable
{
  public const STATUS_OK                   = 200;
  public const STATUS_CREATED              = 201;
  public const STATUS_ACCEPTED             = 202;
  public const STATUS_NO_CONTENT           = 204;
  public const STATUS_MOVED_PERMANENTLY    = 301;
  public const STATUS_FOUND                = 302;
  public const STATUS_NOT_MODIFIED         = 304;
  public const STATUS_TEMPORARY_REDIRECT   = 307;
  public const STATUS_PERMANENT_REDIRECT   = 308;
  public const STATUS_BAD_REQUEST          = 400;
  public const STATUS_UNAUTHORIZED         = 401;
  public const STATUS_FORBIDDEN            = 403;
  public const STATUS_NOT_FOUND            = 404;
  public const STATUS_REQUEST_TIMEOUT      = 408;
  public const STATUS_GONE                 = 410;
  public const STATUS_UNSUPPORTED_MEDIA    = 415;
  public const STATUS_IM_A_TEAPOT          = 418;
  public const STATUS_UNPROCESSABLE_ENTITY = 422;
  public const STATUS_INTERNAL_ERROR       = 500;
  public const STATUS_NOT_IMPLEMENTED      = 501;
  public const STATUS_BAD_GATEWAY          = 502;
  public const STATUS_SERVICE_UNAVAILABLE  = 503;
  public const STATUS_GATEWAY_TIMEOUT      = 504;

  protected string $namespace;

  public function __construct()
  {
    $this->__prepare();
  }

  public function setNamespace(string $namespace = ''): self
  {
    $this->namespace = $namespace;

    return $this;
  }

  protected function isAjax(): bool
  {
    //return 'XMLHttpRequest' === $this->request->getHeader('x-requested-with');
    return Request::ajax();
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
