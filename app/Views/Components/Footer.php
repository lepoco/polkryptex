<?php

/**
 * @package   Polkryptex
 *
 * @copyright Copyright (c) 2021 - Kacper J., Pawel L., Filip S., Szymon K., Leszek P.
 * @license   https://www.gnu.org/licenses/gpl-3.0.txt
 */

?>
</section>
<?php $this->getComponent('ToastContainer'); ?>
<?php foreach ($this->scripts as $script) : ?>
    <script type="<?php echo $script[2]; ?>" src="<?php echo $script[0]; ?>" integrity="<?php echo $script[1]; ?>" crossorigin="anonymous"></script>
<?php endforeach; ?>
</body>

</html>