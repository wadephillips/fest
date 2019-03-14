@extends('layout')

@section('content')

  <registration-page :event="{{ $event->toJson() }}" presenter="{{ $presenter }}"></registration-page>
@endsection