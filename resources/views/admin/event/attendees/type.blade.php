@extends('voyager::master')


@section('content')
  <div class="container">
    <div class="row">
      <h3>{{$attendeeTypeDescription}} attendees of {{$event->name}}</h3>
      <table class="table">
        <thead>
        <tr>
          <th>Name</th>
          <th></th>
        </tr>
        </thead>
        <tbody>
        @forelse($attendees as $attendee)
        <tr>
          <td><a href="{{url('/admin/attendees/' . $attendee->id)}}">{{$attendee->name}}</a></td>
          <td></td>
        </tr>
        @empty
          <tr>
            <td>There are no attendees registered for this type</td>
          </tr>
        @endforelse
        </tbody>
      </table>
    </div>
  </div>

@endsection