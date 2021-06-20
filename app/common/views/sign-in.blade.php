
@include('components.header')

<div class="hero full">
    <div class="hero__column">
        <h1 class="accent">@translate('Sign In')</h1>
        <form id="signin">
            <input type="hidden" name="action" value="SignIn"/>
            <input type="hidden" name="nonce" value="@nonce('signin')"/>
            <div class="mb-3 pr-2">
                <label for="email" class="form-label">@translate('Email')</label>
                <input type="email" class="form-control" name="email">
            </div>
            <div class="mb-3 pr-2">
                <label for="password" class="form-label">@translate('Password')</label>
                <input type="password" class="form-control" name="password">
            </div>
            <button type="submit" class="btn btn-secondary">@translate('Sign in')</button>
        </form>
    </div>
    <div class="hero__column">
        😅
    </div>
</div>

@include('components.footer')
