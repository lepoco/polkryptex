@extends('layouts.app')
@section('content')

<div class="account container pt-5 pb-5">
    <div class="row">
        <div class="col-12 account__section">
            <div class="account__banner h-100 p-5 bg-light rounded-3">
                <div class="account__banner__picture">
                    @if(!empty($user->getImage()))
                        <img class="profile_picture" src="{{ $user->getImage() }}" alt="" />
                    @else
                        <div class="profile_placeholder">
                            @placeholder('100x100')
                        </div>
                    @endif
                </div>
                <div>
                    <h2>@translate('Hello,') {{ $user->getDisplayName() }}</h2>
                    <p>{{ $user->getEmail() }}</p>
                    <a href="{{ $baseUrl . 'dashboard/wallet/transfer' }}" class="btn btn-outline-dark" type="button">@translate('Make a new transfer')</a> <a href="{{ $baseUrl . 'dashboard/wallet/topup' }}" class="btn btn-dark" type="button">@translate('Top up')</a>
                </div>
            </div>
        </div>

        <div class="col-12">
            <form id="account" method="POST">
                <input type="hidden" name="action" value="Account"/>
                <input type="hidden" name="nonce" value="@nonce('account')"/>
                <input type="hidden" name="id" value="{{ $user->getId() }}"/>

                <div class="floating-input">
					<input disabled="disabled" class="floating-input__field -keep-disabled" type="text" name="email" placeholder="@translate('Email')" value="{{ $user->getEmail() }}">
					<label for="email">@translate('Email')</label>
				</div>

                <div class="floating-input">
                    <input disabled="disabled" class="floating-input__field -keep-disabled" type="text" placeholder="@translate('Username')" value="{{ $user->getName() }}" name="username">
                    <label for="username">@translate('Username')</label>
                </div>

                <div class="floating-input">
                    <input class="floating-input__field" type="text" placeholder="@translate('Display name')" value="{{ $user->getDisplayName() }}" name="displayname">
                    <label for="displayname">@translate('Display name')</label>
                </div>

                <div class="floating-input">
                    <input class="floating-input__field" type="file" placeholder="" value="" name="picture">
                    <label for="picture">@translate('Profile picture')</label>
                </div>

                <button type="submit" class="btn btn-dark">@translate('Update')</button>
            </form>
        </div>

        <div class="col-12">
            {{-- @dump($user) --}}
        </div>
    </div>
</div>

@endsection
