<?php

namespace App\Core\Http;

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

    parent::send();

    return $this;
  }

  private function buildSessionCookie(): self
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

    return $this;
  }
}
