
@include('components.header')

<div class="hero full">
    <div class="hero__column">
        <h1 class="accent">@translate('Register')</h1>
        <form id="register">
            <input type="hidden" name="action" value="Register"/>
            <div class="mb-3 pr-2">
                <label for="email" class="form-label">@translate('Email address')</label>
                <input type="email" class="form-control" name="email" aria-describedby="emailHelp">
            </div>
            <div class="mb-3 pr-2">
                <label for="password" class="form-label">@translate('Password')</label>
                <input type="password" class="form-control" name="password">
            </div>
            <button type="submit" class="btn btn-secondary">@translate('Register')</button>
        </form>
    </div>
    <div class="hero__column">
        😅
    </div>
</div>

@include('components.footer')
