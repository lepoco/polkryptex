<?php

namespace App\Core\Http;

use App\Core\Facades\Request;
use App\Core\Data\Encryption;
use Symfony\Component\HttpFoundation\Cookie;

/**
 * Object that stores the HTTP response.
 *
 * @author  Pomianowski <kontakt@rapiddev.pl>
 * @license GPL-3.0 https://www.gnu.org/licenses/gpl-3.0.txt
 * @since   1.1.0
 */
final class Response extends \Symfony\Component\HttpFoundation\Response implements \App\Core\Schema\Response
{
  private string $inlineNonce = '';

  /**
   * Sets a new HTTP header.
   */
  public function setHeader(string $key, $values, bool $replace = true): self
  {
    $this->headers->set($key, $values, $replace);

    return $this;
  }

  /**
   * Removes a HTTP header.
   */
  public function removeHeader(string $key): self
  {
    $this->headers->remove($key);

    return $this;
  }

  /**
   * Sets a new HTTP cookie header.
   */
  public function setCookie(Cookie $cookie): self
  {
    $this->headers->setCookie($cookie);

    return $this;
  }

  /**
   * Removes a HTTP cookie header.
   */
  public function removeCookie(string $key): self
  {
    $this->headers->removeCookie($key);

    return $this;
  }

  /**
   * Gets a HTTP cookie header by given name.
   */
  public function getCookie(string $key): ?Cookie
  {
    $cookies = $this->headers->getCookies();

    foreach ($cookies as $cookie) {
      if ($key === $cookie->getName()) {
        return $cookie;
      }
    }

    return null;
  }

  /**
   * Sends HTTP headers and content.
   */
  public function send(): self
  {
    $this->buildSessionCookie();
    $this->buildSecurityPolicy();
    $this->buildPermanentHeaders();

    parent::send();

    return $this;
  }

  public function getNonce(): string
  {
    if (empty($this->inlineNonce)) {
      $this->inlineNonce = base64_encode(hash('sha512', Encryption::salter(16) . time()));
    }

    return $this->inlineNonce;
  }

  /**
   * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/CSP
   */
  private function buildSecurityPolicy(): void
  {
    $csp = 'default-src ' . Request::root() . ' *.googleapis.com *.gstatic.com;';
    $csp .= ' style-src ' . Request::root() . ' *.googleapis.com *.gstatic.com \'unsafe-inline\';';
    $csp .= ' script-src ' . Request::root() . ' \'nonce-' . $this->getNonce() . '\';';
    $csp .= ' img-src https://*;';
    $csp .= ' child-src \'none\';';

    $this->headers->set('Content-Security-Policy', $csp, true);
  }

  private function buildPermanentHeaders(): void
  {
    $this->headers->remove('cache-control');
    $this->headers->remove('pragma');
    $this->headers->remove('host');
    $this->headers->remove('server');
    $this->headers->remove('expires');
    $this->headers->remove('authorization');
    $this->headers->remove('x-powered-by');

    // Do Not Track
    $this->headers->set('Dnt', 1, true);
    $this->headers->set('Connection', 'keep-alive, close', true);
    $this->headers->set('Upgrade-Insecure-Requests', 1, true);
    $this->headers->set('X-Frame-Options', 'DENY', true);
    $this->headers->set('X-XSS-Protection', '1; mode=block', true);

    // https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Access-Control-Allow-Origin
    $this->headers->set('Access-Control-Allow-Origin', Request::root() . ', https://fonts.googleapis.com, https://fonts.gstatic.com', true);
    $this->headers->set('Vary', 'Origin, Digest', true);

    // https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Date
    // RFC 2822 server time
    $this->headers->set('Date', date('r'), true);

    // https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Digest
    // https://tools.ietf.org/id/draft-ietf-httpbis-digest-headers-01.html
    $this->headers->set('Want-Digest', 'SHA-512', true);
    $this->headers->set('Digest', 'sha-512=' . base64_encode(hash('sha512', $this->content)), true);

    // The RTT network client hint request header field provides the approximate round trip time on the application layer, in milliseconds
    if (defined('APPSTART')) {
      $this->headers->set('RTT', ((int) (microtime(true) - APPSTART) * 1000), true);
    }

    ray($this->headers);
  }

  private function buildSessionCookie(): void
  {
    // TODO: Fix cookies saving

    // $cookies = App::getProperty('container')->get('cookie')->getQueuedCookies();

    // foreach ($cookies as $cookie) {
    //   $this->setCookie($cookie);

    //   if (Session::getId() === $cookie->getName()) {
    //     $this->setCookie(Cookie::create(
    //       Session::getName(),
    //       $cookie->getName(),
    //       $cookie->getExpiresTime(),
    //       $cookie->getPath(),
    //       $cookie->getDomain(),
    //       $cookie->isSecure(),
    //       $cookie->isHttpOnly()
    //     ));
    //   }
    // }
  }
}
