@extends('voyager::master')


@section('content')
  <div class="container-fluid">
    <div class="row">
      @forelse($events as $event)
        <div class="card text-white bg-secondary mb-3">
          <div class="card-header ">
            {{$event->name}}
          </div>
          <div class="card-body">
            <table class="table">
              <thead>
              <tr>
                <th>Registration Type</th>
                <th>Attendees</th>
              </tr>
              </thead>
              <tbody>
              <tr>
                <td scope="row"></td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td scope="row"><strong>Total Attendees</strong></td>

                <td>{{$event->attendeeCount}}</td>
              </tr>
              </tbody>
            </table>

          </div>
        </div>
      @empty
        <h2>There no active events</h2>
      @endforelse
    </div>
  </div>
@endsection