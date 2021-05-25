<?php

/**
 * @package   Polkryptex
 *
 * @copyright Copyright (c) 2021 - Kacper J., Pawel L., Filip S., Szymon K., Leszek P.
 * @license   https://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace Polkryptex;

defined('ABSPATH') or die('No script kiddies please!');

define('POLKRYPTEX_VERSION', '1.0.0');
define('POLKRYPTEX_ALGO', PASSWORD_BCRYPT);

define('POLKRYPTEX_DB_NAME', '');
define('POLKRYPTEX_DB_HOST', '');
define('POLKRYPTEX_DB_USER', '');
define('POLKRYPTEX_DB_PASS', '');

define('SESSION_SALT', '}>I]U!?G+x@c~.<^2&.nq&v>0#DMI?Y@_sJvXp=Dv.HpaR@2Wj.f8otZ|5f@Yf6R');
define('PASSWORD_SALT', '(UEuLn_.qjp.^dhU,ITMEWhU{e~[aYM)&bMryk0fMJ;~AmWRJ9?;oREZD)<%u1#%');
define('NONCE_SALT', 'k>O)fS24Gufs[Hs0:foxvH9^4SX;nE])6-<ZocI>M+<G]|{%v%VJqKJbS)I=XPi>');

define('POLKRYPTEX_DEBUG', true);
