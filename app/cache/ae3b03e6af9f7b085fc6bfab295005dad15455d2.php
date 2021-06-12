
<?php echo $__env->make('components.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<div class="hero full">
    <div class="hero__column">
        <h1 class="accent"><?php echo Polkryptex\Core\Components\Translator::translate('Installer'); ?></h1>

        <form id="install">
            <input type="hidden" name="action" value="Install"/>
            <div class="row">
                <div class="col-12 mb-3">
                    <strong><?php echo Polkryptex\Core\Components\Translator::translate('Database'); ?></strong>
                </div>

                <div class="col-auto mb-1 pr-2">
                    <label for="user" class="form-label"><?php echo Polkryptex\Core\Components\Translator::translate('User'); ?></label>
                    <input type="text" class="form-control" name="user" placeholder="<?php echo Polkryptex\Core\Components\Translator::translate('User'); ?>">
                </div>
                <div class="col-auto mb-1 pr-2">
                    <label for="password" class="form-label"><?php echo Polkryptex\Core\Components\Translator::translate('Password'); ?></label>
                    <input type="text" class="form-control" name="password" placeholder="<?php echo Polkryptex\Core\Components\Translator::translate('Password'); ?>">
                </div>
            </div>

            <div class="row">
                <div class="col-auto mb-1 pr-2">
                    <label for="host" class="form-label"><?php echo Polkryptex\Core\Components\Translator::translate('Host'); ?></label>
                    <input type="text" class="form-control" name="host" placeholder="<?php echo Polkryptex\Core\Components\Translator::translate('Host'); ?>" value="127.0.0.1">
                </div>
                <div class="col-auto mb-1 pr-2">
                    <label for="table" class="form-label"><?php echo Polkryptex\Core\Components\Translator::translate('Table'); ?></label>
                    <input type="text" class="form-control" name="table" placeholder="<?php echo Polkryptex\Core\Components\Translator::translate('Table'); ?>" value="polkryptex">
                </div>
            </div>

            <div class="row">
                <div class="col-12 mb-3 mt-3">
                    <strong><?php echo Polkryptex\Core\Components\Translator::translate('User'); ?></strong>
                </div>

                <div class="col-auto mb-1 pr-2">
                    <label for="admin_username" class="form-label"><?php echo Polkryptex\Core\Components\Translator::translate('Username'); ?></label>
                    <input type="text" class="form-control" name="admin_username" placeholder="User">
                </div>
                <div class="col-auto mb-1 pr-2">
                    <label for="admin_password" class="form-label"><?php echo Polkryptex\Core\Components\Translator::translate('Password'); ?></label>
                    <input type="text" class="form-control" name="admin_password" placeholder="Password">
                </div>
            </div>

            <button type="submit" class="btn btn-dark mt-3"><?php echo Polkryptex\Core\Components\Translator::translate('Begin installation'); ?></button>
        </form>

    </div>
    <div class="hero__column">
        😅
    </div>
</div>

<?php echo $__env->make('components.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH E:\www\rdev\polkryptex\app\common\views/installer.blade.php ENDPATH**/ ?>