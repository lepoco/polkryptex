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

  public const SALT_SESSION = '41NQ0&.(cTHbD8pD5tq&SzHP7cfoSC:goi0=H;pylfeJ*#YNAvo8Q<iJ!sJwDa*#';
  public const SALT_COOKIE = ')t8xKpuV*$hS8=%)sN1Xq=&ABB<#AN2$nw&wgzo$>d_+&%SC0<ZPg8jO$l)K#Big';
  public const SALT_PASSWORD = 'BHv~#5npb+<(XeP<EdZVy$cN(MqY-_^R(7Pt_BG,mYB1kS#v~38:qz?WR8<SlK5l';
  public const SALT_NONCE = 'H%_dudDiRbIY3ggS:YAlKcni3tr#_HR4oH*(RpG_<;neHZr2e+#zcy*Hb%.8I%>*';
  public const SALT_TOKEN = '$+M)w9:%TW7c<Ta8@Z?@7g:JopJ=;SNpaRbz@l.6THxM?lh=Nyti@*o#g.W&n^ie';
  public const SALT_WEBAUTH = 'p6B%H;i0NT7!#ui@FFstgi1X9(:c<ug4%hYjaQIe1.,7f)6D;b,8aRgvr+9;Q%+Z';

  public const DATABASE_NAME = 'polkryptex';
  public const DATABASE_USER = 'root';
  public const DATABASE_PASS = 'root';
  public const DATABASE_HOST = '127.0.0.1';
}
