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

  public const SALT_SESSION = '<zDT?)N;IQsD_>x+j7c=3R<K$>Qk,pFE^l;5X1R1L#Wk,Pjif-K^A,2zXp7^~qGG';
  public const SALT_COOKIE = 'iGE##d0M$q1N(bZUKovdZ6&C)I7ZJUJG~0&AjI ncy8Y7qC=lUTT;bbz5ufXE3.';
  public const SALT_PASSWORD = 'CQ5RPQEzB8iWCpC1o(U1H-!?c,y&2a1n9v5^nwJu-2~YL_*JN&Bb3UQ2)P7KUjwP';
  public const SALT_NONCE = 'H+adaej(rY_U4d!4r43!WOw1xSRKB5Z1w?rX,wU~KwYvrXoTMt;=!VVL2u5bDAwq';
  public const SALT_TOKEN = 'K:;:JzPf0Sy)uUlTWZCQ#0-ULz6_~Zg&^pdF>.=;jgq;z%1P(1<)w,oE8)kri-mK';
  public const SALT_WEBAUTH = 'PK$L6Rn8NE<o_-BL;2pv4>5T8Rh>djC3.-J3,gQ1rp#,t?8T:Qn_3EHL$Ge6Ly6$';

  public const DATABASE_NAME = 'polkryptex';
  public const DATABASE_USER = 'root';
  public const DATABASE_PASS = 'root';
  public const DATABASE_HOST = '127.0.0.1';
}
