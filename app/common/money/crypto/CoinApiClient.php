<?php

namespace App\Common\Money\Crypto;

use Exception;
use InvalidArgumentException;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Sends requests to the Coin API using Symfony HttpClient.
 *
 * @author  Sroka <sroka@polkryptex.pl>
 * @license GPL-3.0 https://www.gnu.org/licenses/gpl-3.0.txt
 * @since   1.2.0
 */
final class CoinApiClient
{
  private const GATEWAY = 'https://rest.coinapi.io/';

  private const GATEWAY_VERSION = 'v1';

  private HttpClientInterface $httpClient;

  public function __construct(string $apiKey)
  {
    if (empty($apiKey)) {
      throw new InvalidArgumentException('API credentials data cannot be empty.');
    }

    $this->httpClient = HttpClient::create([
      'max_redirects' => 1,
      'headers' => [
        'X-CoinAPI-Key' => $apiKey,
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
      self::getEndpoint($endpoint)
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
  private static function getEndpoint(string $path): string
  {
    return self::GATEWAY . self::GATEWAY_VERSION . '/' . trim($path);
  }
}
