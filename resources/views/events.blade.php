@extends('layout')

@section('content')
  <div class="container pb-4">
    <div class="col-sm-8">
      <h1>Upcoming Events</h1>
      <div class="list-group">
        @foreach($events as $event)
          <a href="/events/{{$event->slug}}" class="list-group-item list-group-item-action">{{$event->name}} - {{$event->dates}}</a>
        @endforeach
      </div>
    </div>
  </div>
@endsection