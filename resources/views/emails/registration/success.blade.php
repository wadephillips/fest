@component('mail::message')
# You're going to {{ $event->name }}!

Lets tell you more about that!!

**It's going to be exciting**

@component('mail::panel')
  @component('mail::table')
    | Attendee       | Registration Options        | Amount  |
    | ------------- |:-------------:| ------------:|
    @foreach($attendees as $attendee)
      | {{$attendee['name']}}  | <ul>@foreach($attendee['descriptions'] as $description) <li>{{ $description }}</li> @endforeach</ul> | ${{ $attendee['total'] / 100 }}.00 |
    @endforeach
    |            |                   |           |
    | **Total**  |                   | **${{ $payment->amount/100 }}.00** |
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
