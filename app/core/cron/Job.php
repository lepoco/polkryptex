<?php

namespace App\Core\Cron;

use App\Core\View\Request;

/**
 * CRON job.
 *
 * @author  Pomianowski <kontakt@rapiddev.pl>
 * @license GPL-3.0 https://www.gnu.org/licenses/gpl-3.0.txt
 * @since   1.1.0
 */
abstract class Job implements \App\Core\Schema\Job
{
  abstract public function getName(): string;

  abstract public function getInterval(): string;

  abstract public function process(): void;
}
