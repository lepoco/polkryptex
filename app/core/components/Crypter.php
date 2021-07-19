<?php

/**
 * @package   Polkryptex
 *
 * @copyright Copyright (c) 2021 - Kacper J., Pawel L., Filip S., Szymon K., Leszek P.
 * @license   https://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace App\Core\Components;

/**
 * @author Leszek P.
 */
final class Crypter
{
  /**
   * Gets the application salts.
   *
   * @access   private
   * @return   array
   */
  private static function getSalts(): array
  {
    return [
      'algo'      => defined('APP_ALGO') ? APP_ALGO : '',
      'password'  => defined('APP_PASSWORD_SALT') ? APP_PASSWORD_SALT : '',
      'nonce'     => defined('APP_NONCE_SALT') ? APP_NONCE_SALT : '',
      'session'     => defined('APP_SESSION_SALT') ? APP_SESSION_SALT : '',
      'cookie'     => defined('APP_COOKIE_SALT') ? APP_COOKIE_SALT : ''
    ];
  }

  /**
   * Encrypts data depending on the selected method, default password.
   *
   * @access   public
   * @param    string $string
   * @param    string $type
   * @return   string
   */
  public static function encrypt(
    string $text,
    ?string $type = 'password',
    ?string $customSalt = null,
    /*Mixed*/
    $customAlgo = null
  ): string {

    $salts = self::getSalts();

    if (empty($salts['password'])) {
      $salts['password'] = $customSalt;
    }

    if (empty($salts['nonce'])) {
      $salts['nonce'] = $customSalt;
    }

    if (empty($salts['session'])) {
      $salts['session'] = $customSalt;
    }

    if (empty($salts['cookie'])) {
      $salts['cookie'] = $customSalt;
    }

    if (empty($salts['algo'])) {
      $salts['algo'] = $customAlgo;
    }

    switch ($type) {
      case 'password':
        return (!empty($salts['password']) ? password_hash(hash_hmac('sha256', $text, $salts['password']), $salts['algo']) : '');

      case 'nonce':
        return (!empty($salts['nonce']) ? hash_hmac('sha1', $text . date('Y-m-d h'), $salts['nonce']) : '');
        break;

      case 'session':
        return (!empty($salts['session']) ? hash_hmac('sha256', $text, $salts['session']) : '');
        break;

      case 'cookie':
        return (!empty($salts['cookie']) ? hash_hmac('sha256', $text, $salts['cookie']) : '');
        break;

      default:
        return hash_hmac('sha256', $text, self::salter(60));
    }
  }

  /**
   * Compares encrypted data with those in the database.
   *
   * @access   public
   * @param    string $text
   * @param    string $compare_text
   * @param    string $type
   * @param    bool   $plain
   * @return   bool
   * @link https://php.net/manual/en/function.hash-hmac.php
   * @link https://secure.php.net/manual/en/function.password-verify.php
   */
  public static function compare(
    string $text,
    string $compare_text,
    string $type = 'password',
    bool $plain = true,
    ?string $customSalt = null
  ): bool {

    $salts = self::getSalts();

    if (empty($salts['password'])) {
      $salts['password'] = $customSalt;
    }

    if (empty($salts['nonce'])) {
      $salts['nonce'] = $customSalt;
    }

    if (empty($salts['session'])) {
      $salts['session'] = $customSalt;
    }

    if (empty($salts['cookie'])) {
      $salts['cookie'] = $customSalt;
    }

    switch ($type) {
      case 'password':
        return password_verify(($plain ? hash_hmac('sha256', $text, $salts['password']) : $text), $compare_text);

      case 'nonce':
        return ($plain ? hash_hmac('sha1', $text . date('Y-m-d h'), $salts['nonce']) : $text) == $compare_text;

      case 'session':
        return ($plain ? hash_hmac('sha256', $text, $salts['session']) : $text) == $compare_text;

      case 'cookie':
        return ($plain ? hash_hmac('sha256', $text, $salts['cookie']) : $text) == $compare_text;

      default:
        return false;
    }
  }

  /**
   * Generates a pseudo-random string.
   *
   * @access   public
   * @param    int $length
   * @param    string $pattern
   * @return   string
   * @see https://php.net/manual/en/function.mt-rand.php
   */
  public static function salter(int $length, ?string $pattern = 'ULNS'): string
  {
    self::sRandSeed();

    if (empty($pattern)) {
      $pattern = 'ULNS';
    }
    $pattern = strtoupper($pattern);

    $characters = '';
    if (strpos($pattern, 'U') !== false) {
      $characters .= 'GHIJKLMNOPQRSTUVWXYZABCDEF';
    }

    if (strpos($pattern, 'L') !== false) {
      $characters .= 'abcdefghijklmnopqrstuvwxyz';
    }

    if (strpos($pattern, 'N') !== false) {
      $characters .= '0123456789';
    }

    if (strpos($pattern, 'S') !== false) {
      $characters .= '!@#$%^&*()_+-={}[];:,.<>?|~';
    }

    $rand = '';
    for ($i = 0; $i < $length; $i++) {
      $rand .= $characters[mt_rand(0, strlen($characters) - 1)]; //Mersenne Twist
    }

    return $rand;
  }

  /**
   * Generates a pseudo-random seed.
   *
   * @access   private
   * @return   void
   * @see https://php.net/manual/en/function.mt-srand.php
   */
  private static function sRandSeed(): void
  {
    $characters = '+MNT%#aefbcklmnQRSX67D*&^YZ_oJKLUVWpqijP-=@.z012345EFrstuvdg,?!ABChwxy89GHIO';
    $crx = '';
    for ($i = 0; $i < 50; $i++) {
      $crx .= $characters[mt_rand(0, 75)];
    }

    $rand = intval(crc32(self::buildSeed() . '@' . $crx) * 2147483647);
    mt_srand($rand);
  }

  /**
   * Flips a random seed based on the timecode.
   *
   * @access   private
   * @return   int
   */
  private static function buildSeed(): int
  {
    list($usec, $sec) = explode(' ', microtime());
    return $sec + $usec * 1000000;
  }
}
