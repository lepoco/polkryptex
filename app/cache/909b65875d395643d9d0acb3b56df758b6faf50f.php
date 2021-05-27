
<?php echo $__env->make('components.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('components.navigation', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<div class="container">
    <div class="row">
        <div class="col-12">
            <?php dump(get_defined_vars()); ?>
        </div>
    </div>
</div>

<?php echo $__env->make('components.toast-container', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('components.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH E:\MAMP\htdocs\polkryptex\app\common\views/home.blade.php ENDPATH**/ ?>