<template>
  <div class="container">
    <div class="row">
      <div class="col-sm">
        <hero>
          <template slot="heading">You're going to POCA Fest!</template>
          <template slot="lead">Thanks for registering, its going to be fun!</template>
          
          <template slot="action">
            <a id="poca-forums-btn" class="btn btn-primary"
               href="https://www.pocacoop.com/forums/viewforum/175/"
               role="button" dusk="poca-forums-button" >The POCA Fest Forum</a>

            <a id="pf-toronto-photos-btn" class="btn btn-outline-secondary" href="https://www.pocacoop.com/forums/viewthread/9088/" role="button" dusk="pf-toronto-pictures-button">Pictures from POCA Fest Toronto!</a>
          </template>
        </hero>

        <div class="row mb-4">
          <div class="col-md-8 offset-md-2">
            <h2>Where and When to arrive</h2>

            <p>POCA Fest Milwaukee will be held at the:</p>



            <address>
              <a href="http://www.perlmanretreats.org/contact/directions-map/">Perlman Retreat Center</a>
              W 1802 County Road J<br/>
              Mukwonago, WI 53149
            </address>


            <p>On Friday, May 17 arrive as early as 3pm to catch Friday afternoon programming.
              We’ll say our goodbyes Sunday May 19, 2019 and depart the camp by 2pm.</p>

            <h2>How to get to POCA Fest</h2>

            <h3>Skip says:</h3>
            <blockquote>
              <ol>
                <li>
                  Flying into Milwaukee, the airport is General Mitchell International Airport, MKE. Flying into Chicago, please note Chicago has two airports - O’Hare (ORD) and Midway (MDW). O’Hare is closer to the Perlman Retreat Center. The Milwaukee airport is...I’m finding it difficult enough that I am flying into ORD: O’Hare in Chicago. (MKE tends to be more expensive to fly into but makes up for it with fewer flights into it. Conveniently enough the Perlman Retreat Center is southwest of Milwaukee). Check out both airports and rent a car or grab a shuttle. Here are links to two airport shuttle services - http://www.airportserviceinc.com - https://shuttlewizard.com. We’ll have threads in the POCA forums about ride sharing to either airport.
                </li>

                <li>
                  Why not drive? Here are some of the estimated driving times: Milwaukee 30 minutes, Madison 1.5 hours, Chicago 2 hours or less depending what part of the city you are driving from, Champaign 3.5 hours, Twin Cities 5 hours, Louisville 6 hours, Lincoln NE 8 hours, Buffalo 11 hours, Toronto 12 hours, Denver 15 hours. ROAD TRIP!!!!!!!
                </li>
              </ol>

            </blockquote>

            <h2>What to bring</h2>

            <p>The Perlman provides bedding! Bring a towel, sunscreen, soap, shampoo, toiletries, and good walking
              shoes. The campground’s [sleeping quarters are in
              dormitories](http://www.perlmanretreats.org/facilities/accommodations/dormitory-style/)</p>

          <h2>What else to bring</h2>

            <ol>
              <li>1. If you have a clinic bring business cards- a mess of ‘em-to exchange with other clinics. There
                will be a table laid out for this. Remember! We are all in this together! Support the other POCA clinics
                by using the cards to refer patients!
              </li>
              <li>T-shirt exchange! If you area clinic with t-shirts that you’d love to exchange for t-shirts from
                other clinics, bring ‘em! It’s always fun to see all the different t-shirts we’ve made.
              </li>
              <li>A bag to shop with! Besides the usual assortment of POCA books that you can buy singly or in bulk
                including Acupuncture Points Are Holes, Why did you put that there? Noodles, etc. will be available in
                print. We’ll also have POCA t-shirts.
              </li>
            </ol>

        <h2>More on sleeping at Perlman Retreat Center:</h2>

            <p>We presume that you will sleep some at POCAfest. Excellent! Always good to do. There’s a couple options/things to know:</p>

            <ol>
              <li>There are five dormitories at the camp with beds (where you have to provide your own bedding).  First come first serve. If you want to share a room with specific other people, please note that in the registration form.
              </li>
              <li>What? You got kids? There are rooms that could be used for families. If you want to bring your kids and want to use one of these rooms, please register early so we can accommodate you as these rooms may fill up quick.</li>
            </ol>


            <a href="https://www.pocacoop.com/forums/viewforum/175/" class="btn btn-primary">Additional POCA Fest Information!</a>

            <a href="https://www.pocacoop.com/forums/viewthread/9215/" class="btn btn-primary">Ride share information</a>


            <p><strong>ANY QUESTIONS PLEASE [EMAIL US](mailto:pocafest@pocacoop.com) OR CHECK THE POCA FORUMS</strong>
            </p>

            <p><strong>SEE YOU THERE!</strong></p>

            <p><strong>-Amy, Olive, and Skip - The POCA Events Circle</strong></p>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
            <attendee-table :attendees="this.attendees" :total="this.payment.amount"></attendee-table>
          </div>
        </div>



        <div class="row">
          <div class="col-md-8 offset-md-2">
            <policy>
              <template slot="title">Cancellation Policy</template>
              <p>POCA Fest requires pre-registration and payment in full by the participant.</p>

              <p>For cancellations, following the refund schedule applies:</p>
              <p>Up to 30 days prior to POCA Fest (April 18th)- 100% refund</p>

              <p>29 to 14 days prior to POCA Fest (April 19-May 3rd)- 50 % refund</p>

              <p>13 days or less (after May 4th on)- no refund</p>

              <p>Refunds will be issued within 30 days.</p>
            </policy>
          </div>
        </div>

      </div>
    </div>
  </div>

</template>

<script>
  import Hero from "../../Hero";
  import Policy from "../../registration/success/Policy";
  export default {
    name: "RegistrationSuccessfulPage",
    components: { Hero, Policy},
    props: ['event', 'attendees', 'payment']
  }
</script>

<style scoped>

</style>