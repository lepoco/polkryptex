@extends('layouts.app', [
'title' => 'Dashboard'
])
@section('content')

<div class="account container pt-5 pb-5">
  <div class="row">
    <div class="col-12 account__section">
      <div class="account__banner h-100 p-5 bg-light -rounded-2">
        <div class="account__banner__picture">
          @if(!empty($user->getImage(false)))
          <img lazy class="profile_picture editable__picture" src="{{ $user->getImage(true) }}" alt="@translate('User profile image')" />
          @else
          <img lazy class="profile_picture editable__picture" src="@asset('img/pexels-watch-pay.jpeg')" alt="@translate('User placeholder profile image')" />
          @endif
        </div>
        <div>
          <h4>@translate('Hello,') <span class="editable__displayname">{{ $user->getDisplayName() }}</span></h4>
          <p>{{ $user->getEmail() }}</p>

          <a href="@url('dashboard/transfer')" class="btn btn-outline-dark btn-mobile -lg-mr-1" type="button">@translate('Make a new transfer')</a>
          <a href="@url('dashboard/topup')" class="btn btn-dark btn-mobile" type="button">@translate('Top up')</a>
        </div>
      </div>
    </div>
    <div class="col-12 -mt-5">
      <form id="account" method="POST">
        <input type="hidden" name="action" value="Account" />
        <input type="hidden" name="nonce" value="@nonce('account')" />
        <input type="hidden" name="id" value="{{ $user->getId() }}" />

        <div class="floating-input">
          <input disabled="disabled" class="floating-input__field -keep-disabled" type="text" name="email"
            placeholder="@translate('Email')" value="{{ $user->getEmail() }}">
          <label for="email">@translate('Email')</label>
        </div>

        <div class="floating-input">
          <input class="floating-input__field" type="text" placeholder="@translate('Display name')"
            value="{{ $user->getDisplayName() }}" name="displayname">
          <label for="displayname">@translate('Display name')</label>
        </div>

        <div class="floating-input">
          <input class="floating-input__field" type="file" placeholder="@translate('Profile picture')" value="" name="picture">
          <label for="picture">@translate('Profile picture')</label>
        </div>

        <button type="submit" class="btn btn-dark btn-mobile -lg-mr-1">@translate('Update')</button>
        <a href="@url('dashboard/password')" class="btn btn-outline-dark btn-mobile">@translate('Change your password')</a>
        {{-- <a href="@dashurl('account/two-step')" class="btn btn-outline-dark btn-mobile" type="button">@translate('Two-step
          authentication')</a> --}}
      </form>
    </div>
  </div>
</div>

@endsection