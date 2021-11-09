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

  public const SALT_SESSION = '-NB;!8_~1eOT9^zQwS&hqn?mQzM*iR-OA3~WH0+uT9DxxOCMNJH6?;Mx&xCn7:dI';
  public const SALT_COOKIE = 'qk5YUj^7e~wERFGzQ&+7qsnW&eUAnHWA2Ja9KV6ktT8spk!UL.~5jwVfgkU6oSpp';
  public const SALT_PASSWORD = 's,Yak~Og7By?WRk0lLHPvB7v-u1!@Q^=c?aCN#W?1hnDAYV#BHKxvKEqhgrq:qM9';
  public const SALT_NONCE = 'FBqq;wCBppOs64002qQTaOLW-TCe~dbjxaOAGIc5:CasQ;l0w.:1NpNG;EMueHoT';
  public const SALT_TOKEN = 'P.VPm4K3R8TCm.-OPK.0SkeTV4_rl~pVMY;Z*;Tgg0?o#VOaTiD6.Ux6V*ERt?Ox';
  public const SALT_WEBAUTH = 'pn-!qIihvu+gx0,miq8LGiqnxWdkR2t&yI-:PwC1Bpc6rc1EF;u=M%9z#E@aXZaV';

  public const DATABASE_NAME = 'polkryptex';
  public const DATABASE_USER = 'root';
  public const DATABASE_PASS = 'root';
  public const DATABASE_HOST = '127.0.0.1';
}
