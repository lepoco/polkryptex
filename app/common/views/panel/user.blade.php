@extends('layouts.panel', [
'title' => \App\Core\Facades\Translate::string('User')
])

@section('content')

<div class="dashboard container pt-5 pb-5">

  <form id="panelUser" method="POST">
    <input type="hidden" name="action" value="PanelUser" />
    <input type="hidden" name="nonce" value="@nonce('paneluser')" />

    <div class="row">
      <div class="col-12">
        <h4 class="-font-secondary -fw-700 -pb-3 -reveal">@translate('User')</h4>
      </div>

      @if(!empty($user))

      <div class="col-12 dashboard__section">
        <div class="dashboard__banner h-100 p-5 bg-light -rounded-2 -reveal">
          <div>
            <h4><span class="editable__displayname">{{ $user->getDisplayName() }}</span></h4>
            <p><strong>{{ $user->getUUID() }}</strong></p>
            <p>{{ $user->getEmail() }}</p>
          </div>
        </div>
      </div>

      <div class="col-12 -mt-5">


        <div class="floating-input -reveal">
          <select class="floating-input__field" placeholder="@translate('Role')" data-selected="{{ $user->getRole() }}"
            name="language">
            <option value="1">@translate('Default')</option>
            <option value="2">@translate('Manager')</option>
            <option value="3">@translate('Analyst')</option>
            <option value="4">@translate('Admin')</option>
          </select>
          <label for="language">@translate('Role')</label>
        </div>

        <div class="floating-input -reveal">
          <select class="floating-input__field" placeholder="@translate('Subscription plan')" data-selected="{{ $user->getRole() }}"
            name="language">
            <option value="1">@translate('Default')</option>
            <option value="2">@translate('Manager')</option>
            <option value="3">@translate('Analyst')</option>
            <option value="4">@translate('Admin')</option>
          </select>
          <label for="language">@translate('Subscription plan')</label>
        </div>

      </div>

      <div class="col-12 col-lg-4 -mt-2 -reveal">
        <strong>@translate('Last login')</strong>
        <br>
        {{ !empty($user->getLastLogin()) ? $user->getLastLogin() : '---' }}
      </div>

      <div class="col-12 col-lg-4 -mt-2 -reveal">
        <strong>@translate('Registration date')</strong>
        <br>
        {{ $user->getCreatedAt() }}
      </div>

      <div class="col-12 col-lg-4 -mt-2 -reveal">
        <strong>@translate('Last update')</strong>
        <br>
        {{ $user->getLastUpdate() }}
      </div>

      <div class="col-12 col-lg-4 -mt-2 -reveal">
        <strong>@translate('Is confirmed')</strong>
        <br>
        {{ $user->isConfirmed() ? \App\Core\Facades\Translate::string('Yes') : \App\Core\Facades\Translate::string('No') }}
      </div>

      <div class="col-12 col-lg-4 -mt-2 -reveal">
        <strong>@translate('Is activated')</strong>
        <br>
        {{ $user->isActive() ? \App\Core\Facades\Translate::string('Yes') : \App\Core\Facades\Translate::string('No') }}
      </div>

      <div class="col-12 col-lg-4 -mt-2 -reveal">
        <strong>@translate('Timezone')</strong>
        <br>
        {{ $user->getTimezone() }}
      </div>

      <div class="col-12 -mt-4 -reveal">
        <button id="button_account_activate" name="button_account_activate" type="submit"
          class="btn btn-dark btn-mobile -lg-mr-1">@translate('Activate')</button>
        <button id="button_account_confirm" name="button_account_confirm" type="submit"
          class="btn btn-outline-dark btn-mobile -lg-mr-1">@translate('Confirm')</button>
        <button id="button_account_block" name="button_account_block" type="submit"
          class="btn btn-outline-danger btn-mobile -lg-mr-1">@translate('Block')</button>
        <button id="button_account_delete" name="button_account_delete" type="submit"
          class="btn btn-outline-danger btn-mobile -lg-mr-1">@translate('Delete')</button>
      </div>

      @else

      <div class="col-12 -reveal">
        <p>@translate('User not found.')</p>
      </div>

      @endif
    </div>

  </form>
</div>

@endsection