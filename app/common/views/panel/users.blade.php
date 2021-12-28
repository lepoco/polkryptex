@extends('layouts.panel', [
'title' => \App\Core\Facades\Translate::string('Users')
])

@section('content')

<div class="dashboard container pt-5 pb-5">
  <div class="row">
    <div class="col-12">
      <h4 class="-font-secondary -fw-700 -pb-3 -reveal">@translate('Users')</h4>
    </div>

    <div class="col-12">
      <table class="table table-striped">
        <thead>
          <tr class="-reveal">
            <th scope="col">#</th>
            <th scope="col">@translate('Email')</th>
            <th scope="col">@translate('Display name')</th>
            <th scope="col">@translate('UUID')</th>
            <th scope="col">@translate('Role')</th>
            <th scope="col">@translate('Registration date')</th>
            <th scope="col">@translate('Last login')</th>
            <th scope="col">@translate('Activated')</th>
            <th scope="col">@translate('Confirmed')</th>
          </tr>
        </thead>
        <tbody>

          @isset($users)
          @foreach ($users as $singleUser)
          <tr class="-reveal">
            <th scope="row"><a href="@url('panel/user')/{{ $singleUser->getUUID() }}">{{ $singleUser->getId() }}</a></th>
            <td><a href="@url('panel/user')/{{ $singleUser->getUUID() }}">{{ $singleUser->getEmail() }}</a></td>
            <td>{{ $singleUser->getDisplayName() }}</td>
            <td>{{ $singleUser->getUUID() }}</td>
            <td>{{ ucfirst(\App\Core\Auth\Permission::getRoleName($singleUser->getRole())) }}</td>
            <td>{{ $singleUser->getCreatedAt() }}</td>
            <td>{{ $singleUser->getLastLogin() }}</td>
            <td>{{ $singleUser->isActive() ? 'Yes' : 'No' }}</td>
            <td>{{ $singleUser->isConfirmed() ? 'Yes' : 'No' }}</td>
          </tr>
          @endforeach
          @endisset

        </tbody>
      </table>
    </div>
  </div>
</div>

@endsection