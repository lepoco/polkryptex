<?php

namespace App\Common\Money\Api;

use Exception;
use InvalidArgumentException;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Sends requests to the Open Exchange Rates API using Symfony HttpClient.
 *
 * @author  Pomianowski <support@polkryptex.pl>
 * @license GPL-3.0 https://www.gnu.org/licenses/gpl-3.0.txt
 * @since   1.2.0
 */
final class OpenExchangeRatesClient
{
  private const GATEWAY = 'https://openexchangerates.org/api/';

  private HttpClientInterface $httpClient;

  private string $apiKey;

  public function __construct(string $apiKey)
  {
    if (empty($apiKey)) {
      throw new InvalidArgumentException('API credentials data cannot be empty.');
    }

    $this->apiKey = trim($apiKey);

    $this->httpClient = HttpClient::create([
      'max_redirects' => 1,
      'headers' => [
        'Content-Type' => 'application/json'
      ]
    ]);
  }

  /**
   * Sends a request to the Coin API and processes the received response.
   */
  public function request(string $endpoint): array
  {
    $response = $this->httpClient->request(
      'GET',
      $this->getEndpoint($endpoint)
    );

    if ($response->getStatusCode() !== 200) {
      return [];
    }

    if (!str_contains($response->getHeaders()['content-type'][0] ?? '', 'application/json')) {
      return [];
    }

    if (empty($response->getContent())) {
      return [];
    }

    return $response->toArray();
  }

  /**
   * Creates a URL to the rest Coin API gateway.
   */
  private function getEndpoint(string $path): string
  {
    return self::GATEWAY . '/' . trim($path) . '?app_id=' . $this->apiKey;
  }
}
