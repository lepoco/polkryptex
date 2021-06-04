
<?php echo $__env->make('components.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<div class="hero full">
    <div class="hero__column">
        <h1 class="accent"><?php echo Polkryptex\Core\Components\Translator::translate('Ups!'); ?></h1>
        <p><?php echo Polkryptex\Core\Components\Translator::translate('The page you are looking for has not been found.'); ?></p>

        <a href="/" class="btn btn-dark"><?php echo Polkryptex\Core\Components\Translator::translate('Back to the home page'); ?></a>
    </div>
    <div class="hero__column">
        😅
    </div>
</div>

<?php echo $__env->make('components.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH E:\www\rdev\polkryptex\app\common\views/not-found.blade.php ENDPATH**/ ?>