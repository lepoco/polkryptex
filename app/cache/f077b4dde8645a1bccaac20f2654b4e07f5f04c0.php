
<?php echo $__env->make('components.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('components.navigation', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<div class="container">
    <div class="row">
        <div class="col-12">
            <h2><?php echo Polkryptex\Core\Components\Translator::translate('Wallet'); ?></h2>
        </div>
    </div>
</div>

<?php echo $__env->make('components.toast-container', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('components.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH E:\www\rdev\polkryptex\app\common\views/dashboard/wallet.blade.php ENDPATH**/ ?>