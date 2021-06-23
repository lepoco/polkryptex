@extends('layouts.app')
@section('content')

@php
//https://css.gg/
//https://remixicon.com/
//https://ionic.io/ionicons
//https://feathericons.com/
//https://icons.getbootstrap.com/
@endphp
<div class="pt-5 pb-5 container">
    <div class="row">

        <div class="col-12 pb-5">
            <h2 class="-font-secondary">@translate('Licenses')</h2>
            <hr>
            <p class="-justify">Polkryptex is a web portal whose content management system has been released under the open-source GNU GENERAL PUBLIC LICENSE, version 3.0 license. It uses a number of other open-source technologies, a list of which can be found below.</p>
            <a href="https://github.com/Polkryptex/Polkryptex" target="_blank" rel="noopener nofollow">https://github.com/Polkryptex/Polkryptex</a>
        </div>

        <div class="col-12">
            <ul class="list-unstyled">
                <li><strong>@translate('Open source licenses')</strong></li>

                @php
                    $software = [
                        ['Laravel', 'Taylor Otwell', 'MIT License', 'https://laravel.com/'],
                        ['Jenssegers Blade', 'Jens Segers', 'MIT License', 'https://github.com/jenssegers/blade'],
                        ['Bramus Router', 'Bram(us) Van Damme', 'MIT License', 'https://github.com/bramus/router']
                    ];
                @endphp

                @foreach($software as $single)
                    <li>
                        <p>
                            {{ $single[0] }}
                            <br />
                            <small>Created by {{ $single[1] }} under {{ $single[2] }}</small> - <a href="{{ $single[3] }}">{{ $single[3] }}</a>
                        </p>
                    </li>
                @endforeach

            </ul>
        </div>

    </div>
</div>

@endsection
