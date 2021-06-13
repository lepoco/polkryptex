
<?php echo $__env->make('components.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<div class="hero full">
    <div class="hero__column">
        <h1 class="accent"><?php echo Polkryptex\Core\Components\Translator::translate('Register'); ?></h1>
        <form id="register">
            <input type="hidden" name="action" value="Register"/>
            <div class="mb-3 pr-2">
                <label for="email" class="form-label"><?php echo Polkryptex\Core\Components\Translator::translate('Email address'); ?></label>
                <input type="email" class="form-control" name="email" aria-describedby="emailHelp">
            </div>
            <div class="mb-3 pr-2">
                <label for="password" class="form-label"><?php echo Polkryptex\Core\Components\Translator::translate('Password'); ?></label>
                <input type="password" class="form-control" name="password">
            </div>
            <button type="submit" class="btn btn-secondary"><?php echo Polkryptex\Core\Components\Translator::translate('Register'); ?></button>
        </form>
    </div>
    <div class="hero__column">
        😅
    </div>
</div>

<?php echo $__env->make('components.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH C:\xampp\htdocs\polkryptex\app\common\views/register.blade.php ENDPATH**/ ?>