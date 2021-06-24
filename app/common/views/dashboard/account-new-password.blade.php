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
                </div>
            </div>
        </div>
        <div class="col-12">
            <form id="changePassword" method="POST">
                <input type="hidden" name="action" value="ChangePassword"/>
                <input type="hidden" name="nonce" value="@nonce('account')"/>
                <input type="hidden" name="id" value="{{ $user->getId() }}"/>

                <div class="floating-input">
                    <input class="floating-input__field" type="password" placeholder="@translate('Current password')" name="current_password">
                    <label for="current_password">@translate('Current password')</label>
                </div>

                <div class="floating-input">
                    <input class="floating-input__field" type="password" placeholder="@translate('New password')" name="new_password">
                    <label for="new_password">@translate('New password')</label>
                </div>

                <div class="floating-input">
                    <input class="floating-input__field" type="password" placeholder="@translate('Confirm new password')" name="confirm_new_password">
                    <label for="confirm_new_password">@translate('Confirm new password')</label>
                </div>

                <button type="submit" class="btn btn-dark">@translate('Change your password')</button>
            </form>
        </div>

        <div class="col-12">
            {{-- @dump($user) --}}
        </div>
    </div>
</div>

@endsection
