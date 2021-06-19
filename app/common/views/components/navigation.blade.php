
<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container">
        <a class="navbar-brand" href="/">
            <img src="@media('favicon.svg')" alt="Polkryptex"/>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/">@translate('Home')</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/private">@translate('Private')</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/busisness">@translate('Business')</a>
                </li>
            </ul>
            <div class="d-flex mr-1">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/features">@translate('Features')</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/plans">@translate('Plans')</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/help">@translate('Help')</a>
                    </li>
                </ul>
            </div>
            <div class="d-flex">
                <a href="/signin" class="btn btn-secondary mr-1" type="submit">@translate('Sign in')</a>
                <a href="/register" class="btn btn-dark" type="submit">@translate('Register for free')</a>
            </div>
        </div>
    </div>
</nav>