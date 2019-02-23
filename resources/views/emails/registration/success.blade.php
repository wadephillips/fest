@component('mail::message')
# You're going to POCA Fest!

Lets tell you more about that!!

**It's going to be exciting**

@component('mail::panel')
  @component('mail::table')
    | Attendee       | Email        | Amount  |
    | ------------- |:-------------:| --------:|
    @foreach($attendees as $attendee)
    | {{$attendee['name']}}  | {{$attendee['email']}} | {{$attendee['total']}} |
    @endforeach
    |            |                   |           |
    | **Total**  |                   | **{{$payment->amount}}** |
  @endcomponent
@endcomponent

@component('mail::button', ['url' => 'https://pocacoop.com/forums/177'])
Important arrival information!
@endcomponent

@component('mail::button', ['url' => 'https://pocacoop.com/forums/177'])
Ride share information
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
