@component('mail::message')
# You're going to {{ $event->name }}!
## {{$event->dates}}

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

## Where and When to arrive

POCA Fest Milwaukee will be held at the:

[Perlman Retreat Center](http://www.perlmanretreats.org/contact/directions-map/)

W 1802 County Road J<br/>
Mukwonago, WI 53149

On Friday, May 17 arrive as early as 3pm to catch Friday afternoon programming.
We’ll say our goodbyes Sunday May 19, 2019 and depart the camp by 2pm.


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


