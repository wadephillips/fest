@component('mail::message')
# You're going to {{ $event->name }}!
## {{$event->dates}}

Confirmation Number: {{$payment->id}}
@component('mail::panel')
  @component('mail::table')
    | Attendee       | Registration Options| Amount  |
    | ---------- | :--------  | ------------|
    @foreach($attendees as $attendee)
      | {{$attendee['name']}}  | <ul>@foreach($attendee['descriptions'] as $description) <li>{{ $description }}</li> @endforeach</ul> | ${{ $attendee['total'] / 100 }}.00 |
    @endforeach
    |            |                   |           |
    | **Total**  |                   | **${{ $payment->amount/100 }}.00** |
  @endcomponent
@endcomponent

## Where and When to arrive

POCA Fest Marin will be held at the:

[Headlands Institute](https://www.naturebridge.org/golden-gate/conference-facilities)

Golden Gate National Recreation Area<br/>
1033 Fort Cronkhite<br/>
Sausalito, CA 94965

415-332-5771


On Friday, September 27 arrive as early as 2 pm to catch Friday afternoon programming which starts at 3.
We’ll say our goodbyes Sunday, September 29 and depart the camp by 2pm.

## How to get to POCA Fest
{{--TODO RESUME: Get confirmation on this part and names on schedule then either push it out or build the conference schedule creator--}}
### Skip says:
**By Car:** check out [the Headlands Institute website](https://naturebridge.org/locations/golden-gate) for driving directions.
**By plane:** check both OAK and SFO airports for the best prices then rent a car. (Or pool together to rent a car by advertising for such in the POCAS forums) or check out this shuttle service: http://www.marindoortodoor.com.

## What to bring

Bring a towel, bedding, sunscreen and good walking shoes. There's several great hiking paths along the cliffs and inland which you can explore as you reconnect with your comrade punks. As for the bedding, Marin Headlands provides bunkbeds and you need bedding for them!

Linen packages can be rented from the Headlands Institute for an additional $35 fee at registration. These packages include a fitted sheet, pillow and sleeping bag. Towels are not included in a linen package and there are none to rent. There are only 30 linen packages available to rent, so we ask that those driving in to please bring their own linens.


## What else to bring

1. If you have a clinic bring business cards- a mess of ‘em-to exchange with other clinics. There will be a table laid out for this. Remember!  We are all in this together! Support the other POCA clinics by using the cards to refer patients!
2. T-shirt exchange! If you area clinic with t-shirts that you’d love to exchange for t-shirts from other clinics, bring ‘em! It’s always fun to see all the different t-shirts we’ve made.
3. A bag to shop with! Besides the usual assortment of POCA books that you can buy singly or in bulk including Acupuncture Points Are Holes, Why did you put that there? Noodles, etc.  will be available in print. We’ll also have POCA t-shirts.


@component('mail::button', ['url' => 'https://www.pocacoop.com/forums/viewforum/175/'])
Additional POCA Fest Information!
@endcomponent

@component('mail::button', ['url' => 'https://www.pocacoop.com/forums/viewthread/9215/'])
Ride share information
@endcomponent


ANY QUESTIONS PLEASE [EMAIL US](mailto:pocafest@pocacoop.com) OR CHECK THE POCA FORUMS

SEE YOU THERE!

-Jeff, Mary, and Skip - {{ env('APP_EVENT_HOST') }}

## Cancellation Policy
<p>POCA Fest requires pre-registration and payment in full by the participant.</p>
<p>For cancellations, following the refund schedule applies:</p>
<p>Before September 1<sup>st</sup> - 100% refund</p>
<p>September 1<sup>st</sup> to September 14<sup>th</sup> - 50 % refund</p>
<p>September 15<sup>th</sup> onward - no refund</p>
<p>Refunds will be issued within 30 days.</p>
@endcomponent


