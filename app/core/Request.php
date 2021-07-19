<?php

/**
 * @package   Polkryptex
 *
 * @copyright Copyright (c) 2021 - Kacper J., Pawel L., Filip S., Szymon K., Leszek P.
 * @license   https://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace App\Core;

use Ramsey\Uuid\Uuid;
use App\Core\Components\Crypter;

/**
 * @author Leszek P.
 */
class Request extends Renderable
{
  protected const STATUS_OK                    = 200;
  protected const STATUS_CREATED               = 201;
  protected const STATUS_ACCEPTED              = 202;
  protected const STATUS_NO_CONTENT            = 204;
  protected const STATUS_MOVED_PERMANENTLY     = 301;
  protected const STATUS_FOUND                 = 302;
  protected const STATUS_NOT_MODIFIED          = 304;
  protected const STATUS_TEMPORARY_REDIRECT    = 307;
  protected const STATUS_PERMANENT_REDIRECT    = 308;
  protected const STATUS_BAD_REQUEST           = 400;
  protected const STATUS_UNAUTHORIZED          = 401;
  protected const STATUS_FORBIDDEN             = 403;
  protected const STATUS_NOT_FOUND             = 404;
  protected const STATUS_REQUEST_TIMEOUT       = 408;
  protected const STATUS_GONE                  = 410;
  protected const STATUS_UNSUPPORTED_MEDIA     = 415;
  protected const STATUS_IM_A_TEAPOT           = 418;
  protected const STATUS_UNPROCESSABLE_ENTITY  = 422;
  protected const STATUS_INTERNAL_ERROR        = 500;
  protected const STATUS_NOT_IMPLEMENTED       = 501;
  protected const STATUS_BAD_GATEWAY           = 502;
  protected const STATUS_SERVICE_UNAVAILABLE   = 503;
  protected const STATUS_GATEWAY_TIMEOUT       = 504;

  protected const ERROR_UNKNOWN                  = 'E00';
  protected const ERROR_MISSING_ACTION           = 'E01';
  protected const ERROR_MISSING_NONCE            = 'E02';
  protected const ERROR_INVALID_NONCE            = 'E03';
  protected const ERROR_INVALID_ACTION           = 'E04';
  protected const ERROR_INSUFFICIENT_PERMISSIONS = 'E05';
  protected const ERROR_MISSING_ARGUMENTS        = 'E06';
  protected const ERROR_EMPTY_ARGUMENTS          = 'E07';
  protected const ERROR_ENTRY_EXISTS             = 'E08';
  protected const ERROR_ENTRY_DONT_EXISTS        = 'E09';
  protected const ERROR_INVALID_URL              = 'E10';
  protected const ERROR_INVALID_PASSWORD         = 'E11';
  protected const ERROR_PASSWORDS_DONT_MATCH     = 'E12';
  protected const ERROR_PASSWORD_TOO_SHORT       = 'E13';
  protected const ERROR_PASSWORD_TOO_SIMPLE      = 'E14';
  protected const ERROR_INVALID_EMAIL            = 'E15';
  protected const ERROR_SPECIAL_CHARACTERS       = 'E16';
  protected const ERROR_USER_EMAIL_EXISTS        = 'E17';
  protected const ERROR_USER_NAME_EXISTS         = 'E18';
  protected const ERROR_MYSQL_UNKNOWN            = 'E19';
  protected const ERROR_INVALID_USER             = 'E20';
  protected const ERROR_PASSWORD_CANNOT_BE_SAME  = 'E21';

  protected const CODE_SUCCESS                   = 'S01';

  protected \Nette\Http\Response $response;

  protected \Nette\Http\Request $request;

  protected string $action;

  protected string $method;

  protected array $responseData = [];

  protected array $incomeData = [];

  protected array $requestData = [];

  public function __construct(\Nette\Http\Response $response, \Nette\Http\Request $request)
  {
    $this->response = $response;
    $this->request = $request;

    if (empty($this->request->post) && empty($this->request->url->getQueryParameters())) {
      http_response_code(self::STATUS_BAD_GATEWAY);
      exit('BAD GATEWAY');
    }

    $this->initialize();
    $this->validateAction();
    $this->validateNonce();

    if (method_exists($this, 'action')) {
      $this->{'action'}();
    } else {
      $this->addContent('error', 'Non-existent action');
      $this->finish(self::ERROR_INVALID_ACTION, self::STATUS_BAD_REQUEST);
    }

    $this->finish();
  }

  protected function addContent(string $id, $content): void
  {
    $this->responseData['content'][$id] = $content;
  }

  protected function setStatus(string $status): void
  {
    $this->responseData['status'] = $status;
  }

  protected function finish(?string $status = null, int $responseCode = 200): void
  {
    if ($status !== null) {
      $this->setStatus($status);
    }

    http_response_code($responseCode);
    header('Content-Type: application/json; charset=utf-8');
    \App\Core\Application::stop(json_encode($this->responseData, JSON_UNESCAPED_UNICODE));
  }

  protected function isAjax(): bool
  {
    return 'XMLHttpRequest' === $this->request->getHeader('x-requested-with');
  }

  protected function isSet(array $fields): void
  {
    $notSetField = [];

    foreach ($fields as $field) {
      if (!isset($this->incomeData[$field])) {
        $notSetField[] = $field;
      }
    }

    if (count($notSetField) > 0) {
      $this->addContent('error', 'Non-existent field');
      $this->addContent('notice', 'not-exists');
      $this->addContent('fields', $notSetField);

      $this->addContent('message', $this->translate('Some fields are missing.'));
      $this->finish(self::ERROR_MISSING_ARGUMENTS, self::STATUS_UNPROCESSABLE_ENTITY);
    }
  }

  protected function isEmpty(array $fields): void
  {
    $emptyField = [];
    foreach ($fields as $field) {
      if (!isset($this->incomeData[$field]) || empty($this->incomeData[$field])) {
        $emptyField[] = $field;
      }
    }

    if (count($emptyField) > 0) {
      $this->addContent('error', 'Empty field');
      $this->addContent('notice', 'empty');
      $this->addContent('fields', $emptyField);
      $this->addContent('message', $this->translate('Not all fields are correctly filled.'));
      $this->finish(self::ERROR_EMPTY_ARGUMENTS, self::STATUS_UNPROCESSABLE_ENTITY);
    }
  }

  protected function validate(array $fields): void
  {
    foreach ($fields as $field) {

      if (!isset($field[1])) {
        $field[1] = FILTER_UNSAFE_RAW;
      }

      $value = isset($this->incomeData[$field[0]]) ? $this->incomeData[$field[0]] : null;

      $this->addData(
        $field[0],
        filter_var($value, $field[1])
      );
    }
  }

  protected function addData(string $name, $value): void
  {
    $this->requestData[$name] = $value;
  }

  protected function getData(string $name)
  {
    return $this->requestData[$name] ?? null;
  }

  private function initialize(): void
  {
    $this->method = $this->request->method;

    if ('GET' === $this->method) {
      $this->incomeData = $this->request->url->getQueryParameters();
    }

    if ('POST' === $this->method) {
      $this->incomeData = $this->request->post;
    }

    $this->responseData = [
      'status' => self::ERROR_UNKNOWN,
      'type' => $this->method,
      'content' => [
        'hash' => Crypter::salter(32, 'UN')
      ],
      'uuid' => Uuid::uuid1()->toString()
    ];
  }

  private function validateAction(): void
  {
    if (!isset($this->incomeData['action'])) {
      $this->addContent('error', 'Missing action');
      $this->finish(self::ERROR_MISSING_ACTION, self::STATUS_BAD_REQUEST);
    }

    $this->action = filter_var($this->incomeData['action'], FILTER_SANITIZE_STRING);

    if (empty($this->action)) {
      $this->addContent('error', 'Invalid action');
      $this->finish(self::ERROR_MISSING_ACTION, self::STATUS_BAD_REQUEST);
    }
  }

  private function validateNonce(): void
  {
    if ($this->action == 'Install') {
      return;
    }

    if (!isset($this->incomeData['nonce'])) {
      $this->addContent('error', 'Missing nonce');
      $this->finish(self::ERROR_MISSING_NONCE, self::STATUS_BAD_REQUEST);
    }

    if (!Crypter::compare('ajax_' . strtolower($this->action) . '_nonce', $this->incomeData['nonce'], 'nonce')) {
      $this->addContent('error', 'Invalid nonce');
      $this->addContent('message', $this->translate('The time verification key does not match, please try refreshing the page.'));
      $this->finish(self::ERROR_INVALID_NONCE, self::STATUS_BAD_REQUEST);
    }
  }

  protected function getOption(string $name, $default = null)
  {
    return \App\Core\Registry::get('Options')->get($name, $default);
  }

  protected function translate(string $text, ?array $variables = null): ?string
  {
    return \App\Core\Registry::get('Translator')->translate($text, $variables);
  }
}
