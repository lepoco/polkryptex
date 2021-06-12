<?php

/**
 * @package   Polkryptex
 *
 * @copyright Copyright (c) 2021 - Kacper J., Pawel L., Filip S., Szymon K., Leszek P.
 * @license   https://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace Polkryptex\Core;

/**
 * @author Leszek P.
 */
class Request
{
    protected array $response = [];

    public function __construct()
    {
        if (method_exists($this, 'action')) {
            $this->{'action'}();
        }
        
        $this->finish();
    }

    protected function finish()
    {
        \Polkryptex\Core\Application::stop(json_encode($this->response, JSON_UNESCAPED_UNICODE));
    }
}
