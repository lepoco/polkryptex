
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

                @if(!$auth['loggedIn'])
                    <li class="nav-item">
                        <a class="nav-link{{ $pagenow === 'home' ? ' active' : '' }}" aria-current="page" href="/">@translate('Home')</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link{{ $pagenow === 'private' ? ' active' : '' }}" href="{{ $baseUrl . 'private'}}">@translate('Private')</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link{{ $pagenow === 'busisness' ? ' active' : '' }}" href="{{ $baseUrl . 'busisness'}}">@translate('Business')</a>
                    </li>
                @endif

                @if($debug)
                    <li class="nav-item">
                        <a class="nav-link{{ $pagenow === 'debug' ? ' active' : '' }}" href="{{ $baseUrl . 'debug'}}">@translate('Debug')</a>
                    </li>
                @endif
            </ul>
            <div class="d-flex mr-1">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                    @if($auth['loggedIn'])
                        <li class="nav-item">
                            <a class="nav-link{{ $pagenow === 'dashboard-dashboard' ? ' active' : '' }}" aria-current="page" href="{{ $baseUrl . 'dashboard'}}">@translate('Dashboard')</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link{{ $pagenow === 'dashboard-wallet' ? ' active' : '' }}" aria-current="page" href="{{ $baseUrl . 'dashboard/wallet'}}">@translate('Wallet')</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link{{ $pagenow === 'dashboard-account' ? ' active' : '' }}" aria-current="page" href="{{ $baseUrl . 'dashboard/account'}}">@translate('Account')</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link{{ $pagenow === 'features' ? ' active' : '' }}" aria-current="page" href="{{ $baseUrl . 'features'}}">@translate('Features')</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link{{ $pagenow === 'plans' ? ' active' : '' }}" aria-current="page" href="{{ $baseUrl . 'plans'}}">@translate('Plans')</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link{{ $pagenow === 'help' ? ' active' : '' }}" aria-current="page" href="{{ $baseUrl . 'help'}}">@translate('Help')</a>
                        </li>
                    @endif

                </ul>
            </div>
            <div class="d-flex">

                @if($auth['loggedIn'])
                    <a href="{{ $baseUrl . 'signout'}}" class="btn btn-dark" type="submit">@translate('Sign Out')</a>
                @else
                    <a href="{{ $baseUrl . 'signin'}}" class="btn btn-secondary mr-1" type="submit">@translate('Sign in')</a>
                    <a href="{{ $baseUrl . 'register'}}" class="btn btn-dark" type="submit">@translate('Register for free')</a>
                @endif

            </div>
        </div>
    </div>
</nav>