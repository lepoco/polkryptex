@extends('layouts.panel', [
'title' => \App\Core\Facades\Translate::string('CRON')
])

@section('content')

<div class="dashboard container pt-5 pb-5">
  <div class="row">
    <div class="col-12">
      <h4 class="-font-secondary -fw-700 -pb-3 -reveal">@translate('CRON')</h4>
    </div>

    <div class="col-12 -reveal">
      <strong>Endpoint: </strong>
      <a href="{{$cron_url ?? '#'}}" target="_blank" rel="noopener">{{$cron_url ?? '#'}}</a>
    </div>

    <div class="col-12 -reveal">
      <hr>
    </div>

    <div class="col-12 -reveal">
      <table class="table table-striped">
        <thead>
          <tr class="-reveal">
            <th scope="col">#</th>
            <th scope="col">@translate('Full name')</th>
            <th scope="col">@translate('Name')</th>
            <th scope="col">@translate('Interval')</th>
            <th scope="col">@translate('Last run')</th>
            <th scope="col">@translate('Created at')</th>
          </tr>
        </thead>
        <tbody>

          @isset($jobs)
          @foreach ($jobs as $singleJob)
          <tr class="-reveal">
            <th scope="row">{{ $singleJob['id'] ?? 0 }}</th>
            <td><strong>\\{{ $singleJob['name'] ?? '' }}</strong></td>
            <td>{{ $singleJob['job_name'] ?? '' }}</td>
            <td><strong>{{ $singleJob['interval'] ?? '' }}</strong></td>
            <td>{{ $singleJob['last_run'] ?? '' }}</td>
            <td>{{ $singleJob['created_at'] ?? '' }}</td>
          </tr>
          @endforeach
          @endisset

        </tbody>
      </table>
    </div>
  </div>
</div>

@endsection