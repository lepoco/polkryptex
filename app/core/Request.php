<?php

/**
 * @package   Polkryptex
 *
 * @copyright Copyright (c) 2021 - Kacper J., Pawel L., Filip S., Szymon K., Leszek P.
 * @license   https://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace App\Core;

use Ramsey\Uuid\Uuid;
use Nette\Http\Request as NetteRequest;
use App\Core\Components\Crypter;

/**
 * @author Leszek P.
 */
class Request
{
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

    protected const CODE_SUCCESS                   = 'S01';

    protected NetteRequest $request;

    protected string $action;

    protected string $method;

    private array $response = [];

    private array $incomeData = [];

    private array $requestData = [];

    public function __construct()
    {
        $this->request = Registry::get('Request');

        if (empty($this->request->post) && empty($this->request->url->getQueryParameters())) {
            exit('BAD GATEWAY');
        }

        $this->initialize();
        $this->validateAction();
        $this->validateNonce();

        if (method_exists($this, 'action')) {
            $this->{'action'}();
        } else {
            $this->finish(self::ERROR_INVALID_ACTION);
        }

        $this->finish();
    }

    protected function addContent(string $id, $content): void
    {
        $this->response['content'][$id] = $content;
    }

    protected function setStatus(string $status): void
    {
        $this->response['status'] = $status;
    }

    protected function finish(?string $status = null): void
    {
        if ($status !== null) {
            $this->setStatus($status);
        }

        \App\Core\Application::stop(json_encode($this->response, JSON_UNESCAPED_UNICODE));
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
            $this->addContent('notice', 'not-exists');
            $this->addContent('fields', $notSetField);
            $this->finish(self::ERROR_MISSING_ARGUMENTS);
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
            $this->addContent('notice', 'empty');
            $this->addContent('fields', $emptyField);
            $this->finish(self::ERROR_EMPTY_ARGUMENTS);
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

        $this->response = [
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
            $this->finish(self::ERROR_MISSING_ACTION);
        }

        $this->action = filter_var($this->incomeData['action'], FILTER_SANITIZE_STRING);

        if (empty($this->action)) {
            $this->finish(self::ERROR_MISSING_ACTION);
        }
    }

    private function validateNonce(): void
    {
        if ($this->action == 'Install') {
            return;
        }

        if (!isset($this->incomeData['nonce'])) {
            $this->finish(self::ERROR_MISSING_NONCE);
        }

        if (!Crypter::compare('ajax_' . strtolower($this->action) . '_nonce', $this->incomeData['nonce'], 'nonce')) {
            $this->finish(self::ERROR_INVALID_NONCE);
        }
    }
}
