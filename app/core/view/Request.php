<?php

namespace App\Core\View;

use App\Core\Facades\App;
use App\Core\Facades\Logs;
use App\Core\Facades\Request as IlluminateRequest;
use App\Core\View\Renderable;
use App\Core\Data\Encryption;
use Illuminate\Support\Str;

/**
 * Abstraction for the request, contains the necessary underlying methods.
 *
 * @since 1.0.0
 * @author Pomianowski
 * @license https://www.gnu.org/licenses/gpl-3.0.txt
 */
abstract class Request extends Renderable implements \App\Core\Schema\Request
{
  protected const ERROR_UNKNOWN                  = 'E00';
  protected const ERROR_INTERNAL_ERROR           = 'E01';
  protected const ERROR_MISSING_ARGUMENTS        = 'E02';
  protected const ERROR_EMPTY_ARGUMENTS          = 'E03';
  protected const ERROR_ACTION_MISSING           = 'E04';
  protected const ERROR_ACTION_INVALID           = 'E05';
  protected const ERROR_NONCE_MISSING            = 'E06';
  protected const ERROR_NONCE_INVALID            = 'E07';

  protected const ERROR_MYSQL_UNKNOWN            = 'E08';
  protected const ERROR_SPECIAL_CHARACTERS       = 'E09';
  protected const ERROR_ENTRY_EXISTS             = 'E10';
  protected const ERROR_ENTRY_DONT_EXISTS        = 'E11';
  protected const ERROR_INSUFFICIENT_PERMISSIONS = 'E12';
  protected const ERROR_INVALID_URL              = 'E13';
  protected const ERROR_INVALID_EMAIL            = 'E14';
  protected const ERROR_USER_EMAIL_EXISTS        = 'E15';
  protected const ERROR_USER_NAME_EXISTS         = 'E16';
  protected const ERROR_USER_INVALID             = 'E17';
  protected const ERROR_PASSWORD_INVALID         = 'E18';
  protected const ERROR_PASSWORDS_DONT_MATCH     = 'E19';
  protected const ERROR_PASSWORD_TOO_SHORT       = 'E20';
  protected const ERROR_PASSWORD_TOO_SIMPLE      = 'E21';
  protected const ERROR_PASSWORD_CANNOT_BE_SAME  = 'E22';

  protected const CODE_SUCCESS                   = 'S01';

  protected string $method = '';

  protected array $responseData = [];

  protected array $incomeData = [];

  protected array $requestData = [];

  abstract public function getAction(): string;

  public function print(): void
  {
    Logs::info('New request.', ['action' => $this->getAction(), 'ip' => IlluminateRequest::ip()]);

    $this->initialize();
    $this->validateNonce();

    $this->addContent('hash', Str::random(32));

    if (method_exists($this, 'process')) {
      $this->{'process'}();
    } else {
      $this->addContent('error', 'Non-existent action');
      $this->finish(self::ERROR_ACTION_INVALID, self::STATUS_BAD_REQUEST);
    }
  }

  protected function isSet(array $fields): self
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

      $this->addContent('message', 'Some fields are missing.');
      $this->finish(self::ERROR_MISSING_ARGUMENTS, self::STATUS_UNPROCESSABLE_ENTITY);
    }

    return $this;
  }

  protected function isEmpty(array $fields): self
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
      $this->addContent('message', 'Not all fields are correctly filled.');
      $this->finish(self::ERROR_EMPTY_ARGUMENTS, self::STATUS_UNPROCESSABLE_ENTITY);
    }

    return $this;
  }

  protected function validate(array $fields): self
  {
    foreach ($fields as $field) {
      if (!isset($field[1])) {
        $field[1] = FILTER_UNSAFE_RAW;
      }

      $value = isset($this->incomeData[$field[0]]) ? $this->incomeData[$field[0]] : '';

      $this->addData($field[0], filter_var($value, $field[1]));
    }

    return $this;
  }

  protected function finish(?string $status = '', int $responseCode = 200): void
  {
    if (!empty($status)) {
      $this->setStatus($status);
    }

    http_response_code($responseCode);
    header('Content-Type: application/json; charset=utf-8');

    echo json_encode($this->responseData, JSON_UNESCAPED_UNICODE);

    App::close();
  }

  protected function initialize(): void
  {
    $this->method = IlluminateRequest::method();
    $this->incomeData = IlluminateRequest::toArray();

    $this->responseData = [
      'status' => self::ERROR_UNKNOWN,
      'type' => $this->method,
      'uuid' => (string) Str::uuid(),
      'time' => [
        'timestamp' => time(),
        'timezone' => date_default_timezone_get(),
        'generated' => date('Y-m-d H:i:s')
      ]
    ];
  }

  private function validateNonce(): void
  {
    if ($this->getAction() == 'Install') {
      return;
    }

    if (!IlluminateRequest::has('nonce')) {
      $this->addContent('error', 'Missing nonce');
      $this->finish(self::ERROR_NONCE_MISSING, self::STATUS_BAD_REQUEST);
    }

    if (!Encryption::compare('ajax_' . strtolower($this->getAction()) . '_nonce', IlluminateRequest::get('nonce'), 'nonce')) {
      $this->addContent('error', 'Invalid nonce');
      $this->addContent('message', 'The time verification key does not match, please try refreshing the page.');
      $this->finish(self::ERROR_NONCE_INVALID, self::STATUS_BAD_REQUEST);
    }
  }

  protected function addContent(string $id, $content): void
  {
    $this->responseData['content'][$id] = $content;
  }

  protected function setStatus(string $status): void
  {
    $this->responseData['status'] = $status;
  }

  protected function addResponseData(string $id, $content): void
  {
    $this->responseData[$id] = $content;
  }

  protected function addData(string $name, $value): void
  {
    $this->requestData[$name] = $value;
  }

  protected function getData(string $name)
  {
    return $this->requestData[$name] ?? '';
  }
}
