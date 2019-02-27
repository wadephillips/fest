@extends('layout')

@section('content')
<registration-successful-page
    :event="{{ $event->toJson() }}"
    :attendees="{{ $attendees->toJson() }}"
    :payment="{{ $payment->toJson() }}"

></registration-successful-page>
@endsection