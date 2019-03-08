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

POCA Fest Milwaukee will be held at the:

[Perlman Retreat Center](http://www.perlmanretreats.org/contact/directions-map/)

W 1802 County Road J<br/>
Mukwonago, WI 53149

On Friday, May 17 arrive as early as 3pm to catch Friday afternoon programming.
We’ll say our goodbyes Sunday May 19, 2019 and depart the camp by 2pm.

## How to get to POCA Fest

### Skip says:
> 1. Flying into Milwaukee, the airport is General Mitchell International Airport, MKE. Flying into Chicago, please note Chicago has two airports -  O’Hare (ORD) and Midway (MDW). O’Hare is closer to the Perlman Retreat Center. The Milwaukee airport is...I’m finding it difficult enough that I am flying into ORD: O’Hare in Chicago. (MKE tends to be more expensive to fly into but makes up for it with fewer flights into it. Conveniently enough the Perlman Retreat Center is southwest of Milwaukee). Check out both airports and rent a car or grab a shuttle. Here are links to two airport shuttle services - http://www.airportserviceinc.com - https://shuttlewizard.com. We’ll have threads in the POCA forums about ride sharing to either airport.
>
> 2. Why not drive? Here are some of the estimated driving times: Milwaukee 30 minutes, Madison 1.5 hours, Chicago 2 hours or less depending what part of the city you are driving from, Champaign 3.5 hours, Twin Cities 5 hours, Louisville 6 hours, Lincoln NE 8 hours, Buffalo 11 hours, Toronto 12 hours,  Denver 15 hours. ROAD TRIP!!!!!!!
>

### Driving
Here is a [map that provides driving directions from Milwaukee, Chicago, 	Madison and the Twin Cities](http://www.perlmanretreats.org/contact/directions-map/)

**Please note:** for some reason, sometimes Waze or Google Maps will indicate you have arrived about a mile sooner than it should be.  So, please note these more specific directions. Once you are on County Road J, heading west,  go 2.25 miles and look for the Perlman Retreat Center sign on your right.  It will be a quarter mile after the Beber Camp sign.  If coming from the east on County Road J, watch for the Perlman Retreat Center sign on your left.  *If you see the Beber Camp sign on your right, you have gone too far.*


## What to bring

The Perlman provides bedding!  Bring a towel, sunscreen, soap, shampoo, toiletries, and good walking shoes. The campground’s [sleeping quarters are in dormitories](http://www.perlmanretreats.org/facilities/accommodations/dormitory-style/)

## What else to bring

1. If you have a clinic bring business cards- a mess of ‘em-to exchange with other clinics. There will be a table laid out for this. Remember!  We are all in this together! Support the other POCA clinics by using the cards to refer patients!
2. T-shirt exchange! If you area clinic with t-shirts that you’d love to exchange for t-shirts from other clinics, bring ‘em! It’s always fun to see all the different t-shirts we’ve made.
3. A bag to shop with! Besides the usual assortment of POCA books that you can buy singly or in bulk including Acupuncture Points Are Holes, Why did you put that there? Noodles, etc.  will be available in print. We’ll also have POCA t-shirts.

##  More on sleeping at Perlman Retreat Center:

We presume that you will sleep some at POCAfest. Excellent! Always good to do. There’s a couple options/things to know:

1. There are five dormitories at the camp with beds (where you have to provide your own bedding). First come first serve. If you want to share a room with specific other people, please note that in the registration form.
2. What? You got kids? There are rooms that could be used for families. If you want to bring your kids and want to use one of these rooms, please register early so we can accommodate you as these rooms may fill up quick.



@component('mail::button', ['url' => 'https://www.pocacoop.com/forums/viewforum/175/'])
Additional POCA Fest Information!
@endcomponent

@component('mail::button', ['url' => 'https://www.pocacoop.com/forums/viewthread/9215/'])
Ride share information
@endcomponent


ANY QUESTIONS PLEASE [EMAIL US](mailto:pocafest@pocacoop.com) OR CHECK THE POCA FORUMS

SEE YOU THERE!

-Amy, Olive, and Skip - {{ env('APP_EVENT_HOST') }}

## Cancellation Policy
<p>POCA Fest requires pre-registration and payment in full by the participant.</p>
<p>For cancellations, following the refund schedule applies:</p>
<p>Up to 30 days prior to POCA Fest (April 18th)- 100% refund</p>
<p>29 to 14 days prior to POCA Fest (April 19-May 3rd)- 50 % refund</p>
<p>13 days or less (after May 4th on)- no refund</p>
<p>Refunds will be issued within 30 days.</p>
@endcomponent


