
@include('components.header')

<div class="hero full">
    <div class="hero__column">
        <h1 class="accent">@translate('Sign In')</h1>
        <form id="signin">
            <input type="hidden" name="action" value="SignIn"/>
            <input type="hidden" name="nonce" value="@nonce('signin')"/>
            <div class="mb-3 pr-2">
                <div class="floating-input">
                    <input class="floating-input__field" type="email" name="email" placeholder="@translate('Email')">
                    <label for="email">@translate('Email')</label>
                </div>
            </div>
            <div class="mb-3 pr-2">
                <div class="floating-input">
                    <input class="floating-input__field" type="password" name="password" placeholder="@translate('Password')">
                    <label for="password">@translate('Password')</label>
                </div>
            </div>
            <button type="submit" class="btn btn-dark">@translate('Sign in')</button> <a href="{{ $baseUrl }}" class="btn btn-secondary">@translate('Back to home')</a>
        </form>
    </div>
    <div class="hero__column">
        😅
    </div>
</div>

@include('components.footer')
