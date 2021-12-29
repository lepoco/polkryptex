</div>
@include('components.toast-container')
@include('components.offline')

@iflogged
@include('components.signout')
@endif

{{-- @ifpermission('all') --}}

@if(defined('APPDEBUG') && APPDEBUG)
<code id="app-debug">
  <p><strong>{{ strtoupper(\App\Core\Facades\Option::get('site_name', 'Website')) }} DEBUG | {{ phpversion() }} | {{ php_uname('s') ?? '?' }} </strong></p>
  <p>{{ $pagenow ?? 'Unknown page' }}</p>
  {{-- <p>{{ $__path ?? 'Unknown path' }}</p> --}}
  <p>Server time: {{ (new \DateTime('now'))->format('c') }}</p>
  <span>Cookies:</span>
  @foreach ($_COOKIE as $cookieKey => $cookieValue)
      <span>{{ $cookieKey }}</span>
  @endforeach
  <p>Cached: {{ \App\Core\Facades\Cache::count() ?? 0 }}, Queries: {{ \App\Core\Facades\App::queries() ?? 0 }}</p>
  <p>Defined vars: {{ count(get_defined_vars()) }}</p>
  <p>Rendered: 
  <span>
@php

if(isset($_SERVER["REQUEST_TIME_FLOAT"])) {
echo (microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"]) * 1000 . ' ms';
} else {
echo 'Unknown time';
}
@endphp
</span>
</p>
</code>
@endif

{{-- @endif --}}
</body>

</html>