<div class="h-100 p-5 <?php echo e(isset($dark) ? ($dark ? 'text-white bg-dark' : 'bg-light') : 'bg-light'); ?> rounded-3">
  <h2><?php echo e($title ?? 'Title'); ?></h2>
  <p><?php echo e($text ?? 'text'); ?></p>
  <button class="btn btn-outline-<?php echo e(isset($dark) ? ($dark ? 'light' : 'dark') : 'dark'); ?>" type="button"><?php echo e($button ?? 'Example button'); ?></button>
</div><?php /**PATH E:\www\rdev\polkryptex\app\common\views/components/banner.blade.php ENDPATH**/ ?>