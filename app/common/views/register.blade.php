
@include('components.header')

<div class="hero full">
    <div class="hero__column">
        <h1 class="accent">@translate('Register')</h1>
        <form>
            <div class="mb-3 pr-2">
                <label for="exampleInputEmail1" class="form-label">@translate('Email address')</label>
                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            </div>
            <div class="mb-3 pr-2">
                <label for="exampleInputEmail1" class="form-label">@translate('Password')</label>
                <input type="password" class="form-control" id="exampleInputEmail1">
            </div>
            <button type="submit" class="btn btn-secondary">@translate('Sign in')</button>
        </form>
    </div>
    <div class="hero__column">
        😅
    </div>
</div>

@include('components.footer')
