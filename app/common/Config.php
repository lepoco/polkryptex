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

  public const SALT_SESSION = 'z.EJit=j+#.qY6f@,Xyunz,IuGT)2D+2XnK1E>+2uj:7*1V--C#u?bWsm5B2Dz0&';
  public const SALT_COOKIE = 'k,6&R^n.I~XF0Sq6:<MOf;f.(u1B7^aFAz_vDGY<0a%N@aAY!G&MpX_3SI_A6b&X';
  public const SALT_PASSWORD = ';>LAqDDN<la(JjN;f7zbG:_Tz:JojgrfJ8VE!jK.la<t-)kj0nTAhY^CJnINQG6G';
  public const SALT_NONCE = '^mg19KVi1l&-XwE;1WGuUDkzI#PqgI1%7m65,t)mn9W^UMkBY*n.%qZPit0B=uHE';
  public const SALT_TOKEN = 's4<5FSI*Kq-dU9BW~CoyJ5v5<bOtr)WH#Jn5x#78jHWv!*o8zxuy+hA5JAsqbUQ:';
  public const SALT_WEBAUTH = '!hRzVj=oV#BRW>c2=P2A=%S+qOLCJCiob%I~;;PYeGFEOCc:_oB_fhpbzd@)>&ay';

  public const DATABASE_NAME = 'polkryptex';
  public const DATABASE_USER = 'root';
  public const DATABASE_PASS = 'root';
  public const DATABASE_HOST = '127.0.0.1';
}
