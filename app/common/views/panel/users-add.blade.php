@extends('layouts.panel', [
'title' => \App\Core\Facades\Translate::string('Add new user')
])

@section('content')

<div class="dashboard container pt-5 pb-5">
  <div class="row">
    <div class="col-12">
      <h4 class="-font-secondary -fw-700 -pb-3 -reveal">@translate('Add new user')</h4>
    </div>

    <div class="col-12">
      <form id="panelAddUser" method="POST">
        <input type="hidden" name="action" value="PanelAddUser" />
        <input type="hidden" name="nonce" value="@nonce('paneladduser')" />

        <div class="row">
          <div class="col-12 -mt-1">
            <div class="floating-input -reveal">
              <select class="floating-input__field" placeholder="@translate('Role')" name="user_role">
                <option value="default">@translate('Default')</option>
                <option value="manager">@translate('Manager')</option>
                <option value="analyst">@translate('Analyst')</option>
                <option value="admin">@translate('Admin')</option>
              </select>
              <label for="user_role">@translate('Role')</label>
            </div>
          </div>

          <div class="col-12">
            <div class="floating-input -reveal">
              <input class="floating-input__field" type="email" name="user_email" placeholder="@translate('Email')">
              <label for="user_email">@translate('Email')</label>
            </div>
          </div>

          <div class="col-12">
            <div class="floating-input -reveal">
              <input class="floating-input__field" type="text" name="user_display_name"
                placeholder="@translate('Display name')">
              <label for="user_display_name">@translate('Display name')</label>
            </div>
          </div>

          <div class="col-12">
            <div class="floating-input -reveal">
              <input class="floating-input__field" type="password" name="user_password"
                placeholder="@translate('Password')">
              <label for="user_password">@translate('Password')</label>
            </div>
          </div>

          <div class="col-12">
            <div class="floating-input -reveal">
              <input class="floating-input__field" type="password" name="user_password_confirm"
                placeholder="@translate('Confirm password')">
              <label for="user_password_confirm">@translate('Confirm password')</label>
            </div>
          </div>

          <div class="col-12 -reveal">
            <button type="submit" class="btn btn-dark btn-mobile -lg-mr-1 -reveal">@translate('Add user')</button> 
            <a href="@url('panel/users')" class="btn btn-outline-dark btn-mobile -lg-mr-1 -reveal">@translate('Go back to users')</a>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection