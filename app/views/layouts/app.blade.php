
@include('components.header')
@include('components.navigation')

@yield('content')

@if($auth['loggedIn'])
    @include('components.signout-modal')
@endif

@include('components.expanded-footer')
@include('components.footer')
