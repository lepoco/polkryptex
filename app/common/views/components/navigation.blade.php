<section class="navbar navbar-expand-lg navbar-light {{ $navbarClass ?? '' }}">
  <div class="container">
    <a class="navbar-brand" href="@url">
      {{-- <img loading="lazy" src="@media('favicon.svg')" alt="Polkryptex"/> --}}
      <p>Polkryptex</p>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">

        @if(!$auth['loggedIn'])
        <li class="nav-item">
          <a class="nav-link{{ $pagenow === 'private' ? ' active' : '' }}"
            href="@url('private')">@translate('Private')</a>
        </li>
        <li class="nav-item">
          <a class="nav-link{{ $pagenow === 'business' ? ' active' : '' }}"
            href="@url('business')">@translate('Business')</a>
        </li>
        @endif

        @if($debug)
        <li class="nav-item">
          <a class="nav-link{{ $pagenow === 'debug' ? ' active' : '' }}" href="@url('dashboard/debug')">@translate('Debug')</a>
        </li>
        @endif
        @ifpermission('all')
        <li class="nav-item">
          <a class="nav-link{{ $pagenow === 'admin' ? ' active' : '' }}" href="@url('dashboard/admin')">@translate('Admin')</a>
        </li>
        @endif
      </ul>
      <div class="d-flex -mr-2">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">

          @iflogged
          <li class="nav-item">
            <a class="nav-link{{ $pagenow === 'dashboard-dashboard' ? ' active' : '' }}"
              href="@url('dashboard')">@translate('Dashboard')</a>
          </li>
          <li class="nav-item">
            <a class="nav-link{{ $pagenow === 'dashboard-wallet' ? ' active' : '' }}"
              href="@url('dashboard/wallet')">@translate('Wallet')</a>
          </li>
          <li class="nav-item">
            <a class="nav-link{{ $pagenow === 'dashboard-account' ? ' active' : '' }}"
              href="@url('dashboard/account')">@translate('Account')</a>
          </li>
          @endif

        </ul>
      </div>
      <div class="d-flex">

        @iflogged
        <a href="@url('signout')" class="btn btn-dark" type="submit">@translate('Sign Out')</a>
        @else
        <a href="@url('signin')" class="btn btn-secondary -mr-1" type="submit">@translate('Sign in')</a>
        <a href="@url('register')" class="btn btn-dark" type="submit">@translate('Register for free')</a>
        @endif

      </div>
    </div>
  </div>
</section>