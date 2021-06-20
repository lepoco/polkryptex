
@include('components.header')

<div class="hero full">
    <div class="hero__column">
        <h1 class="accent">@translate('Installer')</h1>

        <form id="install">
            <input type="hidden" name="action" value="Install"/>
            <div class="row">
                <div class="col-12 mb-3">
                    <strong>@translate('Database')</strong>
                </div>

                <div class="col-auto mb-1 pr-2">
                    <label for="user" class="form-label">@translate('User')</label>
                    <input type="text" class="form-control" name="user" placeholder="@translate('User')">
                </div>
                <div class="col-auto mb-1 pr-2">
                    <label for="password" class="form-label">@translate('Password')</label>
                    <input type="text" class="form-control" name="password" placeholder="@translate('Password')">
                </div>
            </div>

            <div class="row">
                <div class="col-auto mb-1 pr-2">
                    <label for="host" class="form-label">@translate('Host')</label>
                    <input type="text" class="form-control" name="host" placeholder="@translate('Host')" value="127.0.0.1">
                </div>
                <div class="col-auto mb-1 pr-2">
                    <label for="table" class="form-label">@translate('Table')</label>
                    <input type="text" class="form-control" name="table" placeholder="@translate('Table')" value="polkryptex">
                </div>
            </div>

            <div class="row">
                <div class="col-12 mb-3 mt-3">
                    <strong>@translate('User')</strong>
                </div>

                <div class="col-auto mb-1 pr-2">
                    <label for="admin_username" class="form-label">@translate('Username')</label>
                    <input type="text" class="form-control" name="admin_username" placeholder="User">
                </div>
                <div class="col-auto mb-1 pr-2">
                    <label for="admin_email" class="form-label">@translate('Email')</label>
                    <input type="email" class="form-control" name="admin_email" placeholder="Email">
                </div>
                <div class="col-auto mb-1 pr-2">
                    <label for="admin_password" class="form-label">@translate('Password')</label>
                    <input type="text" class="form-control" name="admin_password" placeholder="Password">
                </div>
            </div>

            <button type="submit" class="btn btn-dark mt-3">@translate('Begin installation')</button>
        </form>

    </div>
    <div class="hero__column">
        😅
    </div>
</div>

@include('components.footer')
