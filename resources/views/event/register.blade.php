@extends('layout')

@section('content')
  <registration-page :event="{{ $event->toJson() }}"></registration-page>
@endsection