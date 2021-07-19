@extends('layouts.app')
@section('content')

<div class="account container pt-5 pb-5">
    <div class="row">
        <div class="col-12 account__section">
            <div class="account__banner h-100 p-5 bg-light rounded-3">
                <div class="account__banner__picture">
                    @if(!empty($user->getImage(false)))
                        <img class="profile_picture" src="{{ $user->getImage() }}" alt="" />
                    @else
                        <div class="profile_placeholder">
                            @placeholder('100x100')
                        </div>
                    @endif
                </div>
                <div>
                    <h4>@translate('Hello,') {{ $user->getDisplayName() }}</h4>
                    <p>{{ $user->getEmail() }}</p>
                </div>
            </div>
        </div>

        <div class="col-12">
            Recovery codes
            Recovery tokens 
            Security keys 
            Authenticator app
        </div>
        <div class="col-12">
            ...
        </div>
            @php
            $wa = new \App\Core\Authentication\WebAuth();
            $cuser = \App\Core\Authentication\WebAuth::getUserEntity($user);

            

            dump($wa);
            dump($cuser);
            @endphp
    </div>
</div>

@endsection
