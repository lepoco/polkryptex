
<?php echo $__env->make('components.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<div class="hero full">
    <div class="hero__column">
        <h1 class="accent">Installer</h1>

        <form>
            <div class="row">
                <div class="col-12 mb-3">
                    <strong>Database</strong>
                </div>

                <div class="col-auto mb-1 pr-2">
                    <label for="exampleInputEmail1" class="form-label">User</label>
                    <input type="text" class="form-control" placeholder="User">
                </div>
                <div class="col-auto mb-1 pr-2">
                    <label for="exampleInputEmail1" class="form-label">Password</label>
                    <input type="text" class="form-control" placeholder="Password">
                </div>
            </div>

            <div class="row">
                <div class="col-auto mb-1 pr-2">
                    <label for="exampleInputEmail1" class="form-label">Host</label>
                    <input type="text" class="form-control" placeholder="Host" value="127.0.0.1">
                </div>
                <div class="col-auto mb-1 pr-2">
                    <label for="exampleInputEmail1" class="form-label">Table</label>
                    <input type="text" class="form-control" placeholder="Table" value="polkryptex">
                </div>
            </div>

            <div class="row">
                <div class="col-12 mb-3 mt-3">
                    <strong>User</strong>
                </div>

                <div class="col-auto mb-1 pr-2">
                    <label for="exampleInputEmail1" class="form-label">Username</label>
                    <input type="text" class="form-control" placeholder="User">
                </div>
                <div class="col-auto mb-1 pr-2">
                    <label for="exampleInputEmail1" class="form-label">Password</label>
                    <input type="text" class="form-control" placeholder="Password">
                </div>
            </div>

        </form>

        <a href="/" class="btn btn-dark mt-3">Begin installation</a>
    </div>
    <div class="hero__column">
        😅
    </div>
</div>

<?php echo $__env->make('components.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH E:\MAMP\htdocs\polkryptex\app\common\views/installer.blade.php ENDPATH**/ ?>