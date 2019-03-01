@extends('layout')

@section('content')
<registration-successful-page
    :event="{{ json_encode($event) }}"
    :attendees="{{ json_encode($attendees) }}"
    :payment="{{ json_encode($payment) }}"

></registration-successful-page>
@endsection