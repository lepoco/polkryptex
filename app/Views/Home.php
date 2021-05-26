<?php

/**
 * @package   Polkryptex
 *
 * @copyright Copyright (c) 2021 - Kacper J., Pawel L., Filip S., Szymon K., Leszek P.
 * @license   https://www.gnu.org/licenses/gpl-3.0.txt
 */

$this->getComponent('Header');
$this->getComponent('Navigation');
?>

<div class="container">
    <div class="row">
        <div class="col-12">
            <?php $this->testDebugPrint(); ?>
        </div>
    </div>
</div>

<?php $this->getComponent('Footer'); ?>