@extends('layout')

@section('content')
<event-page
    :event="{{ $event->toJson() }}"
    :presenters="{{ $presenters->toJson() }}"
></event-page>
@endsection