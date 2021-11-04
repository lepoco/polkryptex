@extends('layouts.app', [
'title' => \App\Core\Facades\Translate::string('Licenses'),
])
@section('content')
<div class="container -pt-5">
  <div class="row">

    <div class="col-12">
      <h4 class="-font-secondary -fw-700 -pb-3">@translate('Licenses')</h4>
    </div>

    <div class="col-12 -mb-5">
      <div>

        <p>
          Polkryptex Inc - Cryptocurrency platform as a college team IT project.
          <br>
          <small>GNU General Public License v3.0 -</small> <a target="_blank" rel="noopener nofollow"
            href="https://github.com/polkryptex/polkryptex"><small>https://github.com/polkryptex/polkryptex</small></a>
        </p>

        <hr>

        @foreach($softwareList as $software)
        <p>
          {{ $software['name'] ?? '' }}
          <br>
          <small>{{ $software['license'] ?? '' }} -</small> <a target="_blank" rel="noopener nofollow"
            href="{{ $software['url'] ?? '' }}"><small>{{ $software['url'] ?? '' }}</small></a>
        </p>
        @endforeach

      </div>
    </div>
  </div>
</div>

@endsection