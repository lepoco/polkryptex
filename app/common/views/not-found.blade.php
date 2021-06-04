
@include('components.header')

<div class="hero full">
    <div class="hero__column">
        <h1 class="accent">@translate('Ups!')</h1>
        <p>@translate('The page you are looking for has not been found.')</p>

        <a href="/" class="btn btn-dark">@translate('Back to the home page')</a>
    </div>
    <div class="hero__column">
        😅
    </div>
</div>

@include('components.footer')
