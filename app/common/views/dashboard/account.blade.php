@extends('layouts.app', [
'title' => \App\Core\Facades\Translate::string('Account')
])
@section('content')

<div class="dashboard container -mt-5 -mb-5">
  <div class="row">
    <div class="col-12">
      <h4 class="-font-secondary -fw-700 -pb-3 -reveal">@translate('Account')</h4>
    </div>

    <div class="col-12 dashboard__section">
      <div class="dashboard__banner h-100 p-5 bg-light -rounded-2 -reveal">
        <div class="dashboard__banner__picture">
          
          @if($has_profile_picture)
            <img class="editable__picture" data-errorscr="@asset('img/pexels-watch-pay.jpeg')"
              src="{{ ! empty($user->getImage(false)) ? $user->getImage(true) : '' }}"
              alt="{{ $user->getDisplayName() }} Profile image">
          @else
            <img class="editable__picture" data-errorscr="@asset('img/pexels-watch-pay.jpeg')"
              src="@asset('img/pexels-watch-pay.jpeg')"
              alt="{{ $user->getDisplayName() }} Profile image">
          @endif
        </div>
        <div>
          <h4>@translate('Hello,') <span class="editable__displayname">{{ $user->getDisplayName() }}</span></h4>
          <p>{{ $user->getEmail() }}</p>
        </div>
      </div>
    </div>

    <div class="col-12 -mt-2">
      <div class="dashboard__cards">

        @foreach ($user_cards as $user_card)
        
        <div class="dashboard__card h-100 p-1 bg-light -rounded-2 -reveal">
          <div data-provider="{{ $user_card->getProvider() }}" class="dashboard__card__content">
            <div class="-text-center">
              @switch($user_card->getProvider())
                  @case('visa')
                      @media('visa.svg')
                      @break
                  @case(2)
                      
                      @break
                  @default
                  @media('mastercard-horizontal.svg')
              @endswitch
              <p class="-mt-1">(**** {{ substr($user_card->number, -4) }})</p>
            </div>
          </div>
        </div>

        @endforeach

        <div class="dashboard__card h-100 p-1 bg-light -rounded-2 -reveal">
          <div class="dashboard__card__content">
            <a href="@url('dashboard/cards/add')">
              <div class="-text-center">
                <i class="icon-ic_fluent_add_circle_20 -s-24"></i>
                <p>@translate('Add card')</p>
              </div>
            </a>
          </div>
        </div>
      </div>
    </div>

    <div class="col-12 -mt-3">
      <form id="account" method="POST">
        <input type="hidden" name="action" value="Account" />
        <input type="hidden" name="nonce" value="@nonce('account')" />
        <input type="hidden" name="id" value="{{ $user->getId() }}" />

        <div class="floating-input -reveal">
          <input disabled="disabled" class="floating-input__field -keep-disabled" type="text" name="email"
            placeholder="@translate('Email')" value="{{ $user->getEmail() }}">
          <label for="email">@translate('Email')</label>
        </div>

        <div class="floating-input -reveal">
          <input class="floating-input__field" type="text" placeholder="@translate('Display name')"
            value="{{ $user->getDisplayName() }}" name="displayname">
          <label for="displayname">@translate('Display name')</label>
        </div>

        <div class="floating-input -reveal">
          <select class="floating-input__field" placeholder="@translate('Language')"
            data-selected="{{ $user->getLanguage() ?? 'en_US' }}" name="language">
            <option value="en_US">@translate('English')</option>
            <option value="pl_PL">@translate('Polish')</option>
          </select>
          <label for="language">@translate('Language')</label>
        </div>

        <div class="floating-input -reveal">
          <input class="floating-input__field" type="file" placeholder="@translate('Profile picture')" value=""
            name="picture">
          <label for="picture">@translate('Profile picture')</label>
        </div>

        <div class="-pb-1 -reveal">
          <button type="submit" class="btn btn-dark btn-mobile -lg-mr-1">@translate('Update')</button>
          <a href="@url('dashboard/billing')" class="btn btn-outline-dark btn-mobile -lg-mr-1">@translate('Edit your billing details')</a>
          <a href="@url('dashboard/password')" class="btn btn-outline-dark btn-mobile">@translate('Change your password')</a>
          {{-- <a href="@dashurl('account/two-step')" class="btn btn-outline-dark btn-mobile"
            type="button">@translate('Two-step
            authentication')</a> --}}
        </div>

      </form>
    </div>
  </div>
</div>

@endsection