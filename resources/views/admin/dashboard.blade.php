@extends('voyager::master')


@section('content')
  <div class="container-fluid">
    @forelse($events as $event)
      <div class="row">
        <div class="col-md-3">
          <div class="card text-white bg-secondary mb-3">
            <div class="card-header m-3">
              <h4>{{$event->name}}</h4>
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
                @forelse($event->getTotalRegistrationTypes() as $key => $total)
                  <tr>
                    <td>{{$key}}</td>
                    <td>{{$total}}</td>
                  </tr>
                @empty
                  <tr>
                    <td>No registered attendees yet</td>
                  </tr>
                @endforelse
                <td scope="row"><strong>Total Attendees</strong></td>

                <td>{{$event->attendeeCount}}</td>
                </tr>
                </tbody>
              </table>

            </div>
          </div>
        </div>
      </div>
      @empty
      <div class="row">
        <h2>There no active events</h2>
      </div>
    @endforelse
  </div>
@endsection