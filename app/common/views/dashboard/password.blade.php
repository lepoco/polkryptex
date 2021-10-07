@extends('layouts.app', [
'title' => 'Change password'
])
@section('content')

<div class="account container pt-5 pb-5">
  <div class="row">
    <div class="col-12 account__section">
      <div class="account__banner h-100 p-5 bg-light rounded-3">
        <div class="account__banner__picture">
          @if(!empty($user->getImage(false)))
          <img lazy class="profile_picture" src="{{ $user->getImage() }}" alt="@translate('User profile image')" />
          @else
          <img lazy class="profile_picture" src="@asset('img/pexels-watch-pay.jpeg')" alt="@translate('User placeholder profile image')" />
          @endif
        </div>
        <div>
          <h4>@translate('Hello,') {{ $user->getDisplayName() }}</h4>
          <p>{{ $user->getEmail() }}</p>
        </div>
      </div>
    </div>
    <div class="col-12 -mt-5">
      <form id="changePassword" method="POST">
        <input type="hidden" name="action" value="ChangePassword" />
        <input type="hidden" name="nonce" value="@nonce('changepassword')" />
        <input type="hidden" name="id" value="{{ $user->getId() }}" />

        <div class="floating-input">
          <input class="floating-input__field" type="password" placeholder="@translate('Current password')"
            name="current_password">
          <label for="current_password">@translate('Current password')</label>
        </div>

        <div class="floating-input">
          <input class="floating-input__field" type="password" placeholder="@translate('New password')"
            name="new_password">
          <label for="new_password">@translate('New password')</label>
        </div>

        <div class="floating-input">
          <input class="floating-input__field" type="password" placeholder="@translate('Confirm new password')"
            name="new_password_confirm">
          <label for="new_password_confirm">@translate('Confirm new password')</label>
        </div>

        <button type="submit" class="btn btn-dark btn-mobile">@translate('Change your password')</button>
      </form>
    </div>

    <div class="col-12">
      {{-- @dump($user) --}}
    </div>
  </div>
</div>

@endsection