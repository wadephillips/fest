<template xmlns="http://www.w3.org/1999/html">
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

            <!--<a id="pf-toronto-photos-btn" class="btn btn-outline-secondary" href="https://www.pocacoop.com/forums/viewthread/9088/" role="button" dusk="pf-toronto-pictures-button">Pictures from POCA Fest Toronto!</a>-->
          </template>
        </hero>

        <div class="row">
          <div class="col-md-12">
            <attendee-table :attendees="this.attendees" :total="this.payment.amount"></attendee-table>
          </div>
        </div>

        <div class="row mb-4">
          <div class="col-md-8 offset-md-2">
            <h2>Where and When to arrive</h2>

            <p>POCA Fest Marin will be held at the:</p>

            <address>
              <a href="https://www.naturebridge.org/golden-gate/conference-facilities">Headlands Institute</a>
              Golden Gate National Recreation Area<br/>
              1033 Fort Cronkhite<br/>
              Sausalito, CA 94965
            </address>

            <p>415-332-5771</p>


            <p>On Friday, September 27 arrive as early as 2 pm to catch Friday afternoon programming which starts at 3.
              We’ll say our goodbyes Sunday, September 29 and depart the camp by 2pm.</p>

            <h2>How to get to POCA Fest</h2>

            <h3>Skip says:</h3>
            <blockquote>
              <ol>
                <li>
                  <strong>By Car:</strong> check out <a href="https://naturebridge.org/locations/golden-gate">the Headlands Institute website</a> for driving directions.
                </li>

                <li>
                  <strong>By plane:</strong> check both OAK and SFO airports for the best prices then rent a car. (Or pool together to rent a car by advertising for such in the POCAS forums) or check out this <a href="http://www.marindoortodoor.com">shuttle service</a>.
                </li>
              </ol>

            </blockquote>


            <h2>What to bring</h2>

            <p>Bring a towel, bedding, sunscreen and good walking shoes. There's several great hiking paths along the cliffs and inland which you can explore as you reconnect with your comrade punks. As for the bedding, Marin Headlands provides bunk beds and you need bedding for them!</p>

            <p>Linen packages can be rented from the Headlands Institute for an additional $35 fee at registration. These packages include a fitted sheet, pillow and sleeping bag. Towels are not included in a linen package and there are none to rent. There are only 30 linen packages available to rent, so we ask that those driving in to please bring their own linens.</p>

          <h2>What else to bring</h2>

            <ol>
              <li>If you have a clinic bring business cards- a mess of ‘em-to exchange with other clinics. There
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


            <a href="https://www.pocacoop.com/forums/viewforum/175/" class="btn btn-primary">Additional POCA Fest Information!</a>

            <a href="https://www.pocacoop.com/forums/viewthread/9308/" class="btn btn-primary">Ride share information</a>


            <p><strong>ANY QUESTIONS PLEASE <a href="mailto:pocafest@pocacoop.com">EMAIL US</a> OR CHECK THE POCA FORUMS</strong>
            </p>

            <p><strong>SEE YOU THERE!</strong></p>

            <p><strong>-Jeff, Mary, and Skip - The POCA Events Circle</strong></p>
          </div>
        </div>

        <hr>



        <div class="row">
          <div class="col-md-8 offset-md-2">
            <policy>
              <template slot="title">Cancellation Policy</template>
              <p>POCA Fest requires pre-registration and payment in full by the participant.</p>

              <p>For cancellations, following the refund schedule applies:</p>
              <p>Up to 30 days prior to POCA Fest (September 1<sup>st</sup>)- 100% refund</p>

              <p>29 to 14 days prior to POCA Fest (September 1<sup>st</sup> to September 14<sup>th</sup>)- 50 % refund</p>

              <p>13 days or less (September 15<sup>th</sup> onward )- no refund</p>

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