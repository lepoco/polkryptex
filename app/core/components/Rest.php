<?php

/**
 * @package   Polkryptex
 *
 * @copyright Copyright (c) 2021 - Kacper J., Pawel L., Filip S., Szymon K., Leszek P.
 * @license   https://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace App\Core\Components;

use App\Core\Renderable;
use Nette\Http\UrlScript;
use Ramsey\Uuid\Uuid;
use App\Core\Components\Crypter;

/**
 * Representational State Transfer
 * 
 * @see https://restfulapi.net/rest-architectural-constraints/
 * @author Leszek P.
 */
class Rest extends Renderable
{
  protected \Nette\Http\Response $response;

  protected \Nette\Http\Request $request;

  protected string $endpoint = '';

  protected array $responseData = [];

  public function __construct(\Nette\Http\Response $response, \Nette\Http\Request $request)
  {
    $this->response = $response;
    $this->request = $request;

    $url = $request->getUrl();
    $this->endpoint = $url->getRelativePath();

    $this->responseData = ['data' => [], 'errors' => []];

    $this->addError(200, 'Invalid action', ['/here']);
    
    $parts = explode('/', $url->getRelativePath());
    // dump($parts);

    // dump($url);
    // dump($url->getRelativePath());
    // dump($url->getScheme());
    // dump($url->getHost());
    // dump($url->getDomain());
    // dump($url->getPort());
    // dump($url->getQuery());
    // dump($url->getFragment());
    // dump($url->jsonSerialize());
    // dump($url->export());

    
    
    $this->finish();
  }

  protected function addError(int $code, string $title, array $source = [], ?string $detail = null): void
  {
    $this->responseData['errors'][] = [
      'code' => $code,
      'title' => $title,
      'source' => $source,
      'detail' => $detail
    ];
  }

  protected function finish(int $responseCode = 200): void
  {
    $this->responseData['version'] = \App\Common\App::APP_VERSION;
    $this->responseData['server_time'] = (new \DateTime)->getTimestamp();
    $this->responseData['actions'] = $this->getPublicActions();

    http_response_code($responseCode);
    header('Content-Type: application/vnd.api+json; charset=utf-8');
    \App\Core\Application::stop(json_encode($this->responseData, JSON_UNESCAPED_UNICODE));
  }

  protected function getPublicActions(): array
  {
    $class = get_class($this);

    return [$this->endpoint . '/abc'];
  }
}