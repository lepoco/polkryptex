<?php

namespace App\Common;

/**
 * Dynamic configuration.
 *
 * @author  Pomianowski <kontakt@rapiddev.pl>
 * @license GPL-3.0 https://www.gnu.org/licenses/gpl-3.0.txt
 * @since   1.1.0
 */
final class Config implements \App\Core\Schema\Config
{
  public const ENCRYPTION_ALGO = 'argon2id';

  public const SALT_SESSION = 'qx@tpc:VB+DJcGc0@To9As=LvyNXdVp^1KF,S&,:V?vUwRouDN4Qyrj6D:w*-U!r';
  public const SALT_COOKIE = 'v_D8yh?wxQ?8H~YARZ4RYD2dXtXCv#5sM^5bB.%Gb?ILrNivbsofgoMbCwM:lP?h';
  public const SALT_PASSWORD = 'x1ffMy!Xam;TM6QM1Qcy@f+.uOQT^OzV4Yn^?5FJv!bqMP_=HwWU8?wwCr-L3@.R';
  public const SALT_NONCE = '+&w9+8!CHqcmYZDezAGnDO5N7c8OAPQlZjQtWDcs^hAS,n^!0kh%afn+Cgih~3R&';
  public const SALT_TOKEN = 'X_lFO,H7hF~rtvdTmpNIyZEb&bPO@iw0=KUAaTNb3MGST?fM+0oZzKxI&wTXVlIr';
  public const SALT_WEBAUTH = 'eARMY-^1xS#c!w8jR4z%La8INYn&Gp2V&SlhbMWm:TZF:=9wtBv-4&HYVQqymhTZ';
  public const SALT_PASSPHRASE = 'qwv05NkJo3IajunP84^op;X?;cIxV4ZPe*~EbGwaV!5l..T6C1OS^YN6ddwEo8h?';

  public const DATABASE_NAME = 'polkryptex';
  public const DATABASE_USER = 'root';
  public const DATABASE_PASS = '';
  public const DATABASE_HOST = '127.0.0.1';
}
