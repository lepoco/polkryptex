<?php

/**
 * @package   Polkryptex
 *
 * @copyright Copyright (c) 2021 - Kacper J., Pawel L., Filip S., Szymon K., Leszek P.
 * @license   https://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace Polkryptex\Core;

use Polkryptex\Core\Shared\Crypter;

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

    protected const CODE_SUCCESS                   = 'S01';

    protected string $action;

    private array $response = [];

    private array $requestData = [];

    public function __construct()
    {
        $this->initializeResponse();
        
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

        \Polkryptex\Core\Application::stop(json_encode($this->response, JSON_UNESCAPED_UNICODE));
    }

    protected function isSet(array $fields): void
    {
        $notSetField = [];
        foreach ($fields as $field) {
            if(!isset($_REQUEST[$field]))
            {
                $notSetField[] = $field;
            }
        }

        if(count($notSetField) > 0)
        {
            $this->addContent('notice', 'not-exists');
            $this->addContent('fields', $notSetField);
            $this->finish(self::ERROR_MISSING_ARGUMENTS);
        }
    }

    protected function isEmpty(array $fields): void
    {
        $emptyField = [];
        foreach ($fields as $field) {
            if (!isset($_REQUEST[$field])) {
                $emptyField[] = $field;
            } else if (empty($_REQUEST[$field])) {
                $emptyField[] = $field;
            }
        }

        if (count($emptyField) > 0) {
            $this->addContent('notice', 'empty');
            $this->addContent('fields', $emptyField);
            $this->finish(self::ERROR_EMPTY_ARGUMENTS);
        }
    }

    protected function filter(array $fields): void
    {
        foreach ($fields as $field) {
            $this->addData($field[0], $_REQUEST[$field[0]]);
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

    private function initializeResponse(): void
    {
        $this->response = [
            'status' => self::ERROR_UNKNOWN,
            'content' => [
                'hash' => \Polkryptex\Core\Shared\Crypter::salter(32, 'UN')
            ]
        ];
    }

    private function validateAction(): void
    {
        if (!isset($_REQUEST['action'])) {
            $this->finish(self::ERROR_MISSING_ACTION);
        }

        $this->action = filter_var($_REQUEST['action'], FILTER_SANITIZE_STRING);
    }

    private function validateNonce(): void
    {
        if ($this->action == 'Install') {
            return;
        }

        if (!isset($_REQUEST['nonce'])) {
            $this->finish(self::ERROR_MISSING_NONCE);
        }

        if (!Crypter::compare('ajax_' . strtolower($this->action) . '_nonce', filter_var($_REQUEST['nonce'], FILTER_SANITIZE_STRING), 'nonce')) {
            $this->finish(self::ERROR_INVALID_NONCE);
        }
    }
}
