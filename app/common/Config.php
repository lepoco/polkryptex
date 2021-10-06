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

  public const SALT_SESSION = '*t9xs;AssVGiLNAQiXXUxP@~581zix<!9~Ogml+RDI&O;L;*SmU==b<5pB.9Ys~i';
  public const SALT_COOKIE = '38*Yj0fAq8Pc+8<u<.@yoyW<ptl)G5YFf#u7SSF%IKi&&_pH9^ds!U@e&9bGh-ut';
  public const SALT_PASSWORD = '=>08-F0wYap~1.W?hQWOL5PWrt9)P1hHFTKaC*1&?LdcH:$fV9qW*o@hoF?~tndS';
  public const SALT_NONCE = 'w%S$Evg)KXdlLZDktLD6jSIzeE%A0lSCF2n3QuCMy<ZyI_<;@*~gSqz$qgTZc0qw';
  public const SALT_TOKEN = 'Cv6hBCmvwEEOIgc,5w2-s~?tfzaX4Nyo)xn&JsZG,PjrdVYueCRy5=7fZd2o%sh9';
  public const SALT_WEBAUTH = '=#v#mjT;:SNHdAsHC(;!omN9<M<&ASfD_qp<D*S8@%OvMx9*)HhlZs-PGT.xAw?6';

  public const DATABASE_NAME = 'polkryptex';
  public const DATABASE_USER = 'root';
  public const DATABASE_PASS = 'root';
  public const DATABASE_HOST = '127.0.0.1';
}
