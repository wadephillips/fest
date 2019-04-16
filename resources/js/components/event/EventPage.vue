<template>
  <main>
    <nav-menu :linkObjects="this.links" ></nav-menu>
    <div data-offset="0" data-spy="scroll" data-target="#eventNavbar">
      <!--Hero-->
      <info-section id="home" class="pt-5">
        <template slot="heading">
          <h1 class="text-center py-3">{{event.name}}</h1>
        </template>

        <template slot="subheading">
          <h3 class="text-center py-3">{{this.eventDates}}</h3>
        </template>

        <template slot="default">
          <div class="col-md">
            <p class="lead py-5">{{ event.description}}</p>
          </div>
        </template>

      </info-section>

      <hr>
      <info-section id="theme" >
        <template slot="heading">
          <h2 class="text-center">Theme</h2>
        </template>
        <template slot="subheading">
          <h3 class="text-center">Practical Interventions</h3>
        </template>
        <template slot="image-left">
          <div class="col-md-6">
            <img alt="" class="img-responsive" src="/img/chair.svg"/>
          </div>
        </template>
        <template slot="default">
          <div class="col-md-6 text-center pt-4"><p class="lead">At this POCAfest we are gonna look at the basics: what
            makes a CA clinic
            work and not just work-sing.</p>
            <p>We are gonna do this in two ways:</p>
            <p>1) Lisa Rohleder is making the keynote speech on The Hierarchy of Needs that all CA clinics need to take
              care
              of in order to be a sustainable small business. Many of the Breakouts relate to this hierarchy (and you
              can
              <a href="https://www.pocacoop.com/prick-prod-provoke/">read about it in Prick, Prod, and Provoke</a>)</p>
            <p>2) We will also be hosting our first auricular training for punks and non punks led by Ellen Vincent,
              Caroline Picker, Susan Williams, Amy Severinsen and Olivia Crane. (For a full description of this, read
              below,
              right after the logistics of registration and traveling to POCAfest and above the Schedule.)</p></div>
        </template>
      </info-section>

      <hr>
      <info-section id="auricular">
        <template slot="heading">
          <h2 class="text-center">POCA Auricular Acu-Technician Training and Certification</h2>
        </template>
        <template slot="subheading">
          <p class="lead text-center">Join us for the inaugural POCA Auricular Acu-Technician Training and Certification
            Course!</p>
        </template>
        <template slot="default">
          <div class="col-md-6 mt-3">
            <p>Learn the 5 Needle Protocol for addiction, trauma, and behavioral health. Anyone is welcome to take this
              training, though <strong>space is limited</strong>.</p>

            <p>For non-acupuncturists, attending this entire series of breakout sessions is the first step towards
              earning
              an Auricular Acu-Technican Certificate.** </p>

            <p>Included in the registration fee is the second step towards certification: access to our 14-hour online
              course materials about trauma-informed auricular acupuncture, starting with the history of auricular
              acupuncture, the 5 Needle Protocol and its applications / implementation, the neuroscience of trauma and
              addiction as well as the social and structural determinants of health & addiction, harm reduction, the
              neuroscience of acupuncture, and issues surrounding legislation. The third and final step towards
              certification will be the successful completion of 40 ear treatments, either supervised at an in-person
              ear
              clinic or if necessary, via distance-supervision. </p>
            <p><strong>Attending this course in its entirety is strongly encouraged for any licensed acupuncturists who
              are interested in becoming a POCA-certified Trainer of Auricular Acu-Technicians.</strong> We will get
              into detail (and answer all of your questions!) about the certification process itself, as well as how and
              why we got here, in one of the breakout sessions.</p>

            <p class="small">**Attending this training does not guarantee that the trainee will be able to legally
              practice auricular acupuncture or the 5NP in trainee's state of residence. If a Wisconsin resident, this
              Auricular Acu-Technician Certificate will enable trainee to practice this protocol legally under physician
              delegation.</p>

          </div>
        </template>
        <template slot="image-right">
          <div class="col-md-6">
            <img alt="" class="img-responsive" src="/img/ear.svg"/>
          </div>
        </template>
      </info-section>
      <hr>
      <!--Location-->
      <info-section id="location">
        <template slot="heading">
          <h2 class="text-center my-3">Location</h2>

        </template>

        <template slot="default">
          <div class="col-md-6">
            <p>
              POCA Fest Milwaukee will be held at <a href="http://www.perlmanretreats.org/">Perlman Retreat Center</a>.</p>
            <location-address
                :address="this.event.address"
                :address_2="this.event.address_2"
                :city="this.event.city"
                :name="this.event.location_name"
                :postal="this.event.postal"
                :state="this.event.state"
                :suite="this.event.suite"
            ></location-address>
            <p>
              Here are <a href="http://www.perlmanretreats.org/contact/directions-map/">driving directions from Milwaukee, Chicago, Madison, and the Twin
              Cities</a>.</p>

            <p>
              <strong>Please note:</strong> for some reason, sometimes Waze or Google Maps will indicate you have
              arrived about a mile sooner than it should be. So, please note these more specific direction. Once you are
              on County Road J, heading west, go 2.25 miles and look for the Perlman Retreat Center sign on your right.
              It will be a quarter mile after the Beber Camp sign. If coming from the east on County Road J, watch for
              the Perlman Retreat Center sign on your left.
              <em>If you see the Beber Camp sign on your right, you have gone too far.</em>
            </p>
          </div>
        </template>
        <template slot="image-right">
          <div class="col-md">
            <fest-map api-key="AIzaSyCSdbPjbn7KYWaFGl6Cy8EYD1l1YVCTGL8"
                      place-id="ChIJFY5ircKXBYgRXS2rAIsCc4Q"></fest-map>
          </div>
        </template>
      </info-section>

      <hr>
      <!--Fees-->
      <info-section id="fees">

        <template slot="heading">
          <h2 class="text-center my-3">Conference Fees</h2>
        </template>

        <template slot="default">
          <hr>
          <div class="col-md-8">
            <div class="text-center" v-for="fee in this.event.fees">
              <fee :fee="fee"></fee>
            </div>

          </div>
        </template>

        <template slot="image-right">
          <div class="col-md">
            <div class="card bg-light border-light">
              <div class="card-body">
                <h4 class="card-title">Acu-Market Scholarship</h4>
                <p class="card-text">Do you want to attend POCA Fest in Mukwonago, WI this Spring but can’t afford it?</p>
                <p>Well you may be in luck! This year Acu-Market has sponsored our POCA Fest and is sending two lucky comrades to POCA Fest for FREE! That’s right, the fest including your lodging and meals are included. <em>POCA Memebers only!</em></p>
                <p class="card-text"><small class="text-muted">Application deadline is Sunday, April 28, 2019. Two winners
                  will be selected on Wednesday, May 1, 2019.</small></p>
                <a href="https://forms.gle/c4WfcTnHA42Z1pRJ6" class="btn btn-outline-primary">Apply for the Acu-Market Scholarship</a>
              </div>
            </div>
          </div>
        </template>

      </info-section>

      <hr>
      <!--schedule-->
      <info-section id="schedule">
        <template slot="heading">
          <h2 class="text-center">Conference Schedule</h2>
        </template>

        <schedule></schedule>
      </info-section>

      <hr>
      <!--Breakouts-->
      <info-section id="breakouts">
        <template slot="heading">
          <h2 class="text-center">Breakouts</h2>
        </template>

        <div class="card-columns">
          <breakout :breakout="breakout" :key="breakout.id" v-for="breakout in this.event.breakouts"></breakout>
        </div>

      </info-section>

      <hr>
      <!--Presenters-->
      <info-section id="presenters">
        <template slot="heading">
          <h2 class="text-center">Presenters</h2>
        </template>
        <div class="card-columns">
          <presenter :key="presenter.id" :presenter="presenter" v-for="presenter in this.presenters"></presenter>
        </div>
      </info-section>
    </div>
  </main>
</template>

<script>
  import InfoSection from './InfoSection'
  import {dates} from "../mixins/dates";
  import Fee from './Fee'
  import Presenter from "./Presenter";
  import Breakout from "./Breakout";
  import LocationAddress from "../LocationAddress";
  import FestMap from "./FestMap";

  export default {
    name: "EventPage",
    props: ['event', 'presenters'],
    components: {FestMap, LocationAddress, Breakout, Presenter, InfoSection, Fee},
    mixins: [dates],
    data() {
      return {
        links: [
          {
            a: "/events/" + this.event.slug + "/register",
            description: 'Register',
            styleClasses: 'btn btn-danger'
          },
          {
            a: '#theme',
            description: 'Theme',
            styleClasses: 'nav-link'
          },
          {
            a: '#auricular',
            description: 'Auricular Certification',
            styleClasses: 'nav-link'
          },
          {
            a: '#location',
            description: 'Location',
            styleClasses: 'nav-link'
          },
          {
            a: '#fees',
            description: 'Fees',
            styleClasses: 'nav-link'
          },
          {
            a: '#schedule',
            description: 'Schedule',
            styleClasses: 'nav-link'
          },
          {
            a: '#breakouts',
            description: 'Breakouts',
            styleClasses: 'nav-link'
          },
          {
            a: '#presenters',
            description: 'Presenters',
            styleClasses: 'nav-link'
          },
        ]
      }
    },
    computed: {
      registrationUrl() {
        return "/events/" + this.event.slug + "/register"
      }
    },
    created() {
      // The function actually applying the offset
      function offsetAnchor() {
        if (location.hash.length !== 0) {
          window.scrollTo(window.scrollX, window.scrollY - 100);
        }
      }

      // Captures click events of all <a> elements with href starting with #
      $(document).on('click', 'a[href^="#"]', function (event) {
        // Click events are captured before hashchanges. Timeout
        // causes offsetAnchor to be called after the page jump.
        window.setTimeout(function () {
          offsetAnchor();
        }, 0);
      });

      // Set the offset when entering page with hash present in the url
      window.setTimeout(offsetAnchor, 0);
    }
  }
</script>

<style scoped>
  #home {
    background-image: linear-gradient(
        rgba(0, 0, 0, 0.5),
        rgba(0, 0, 0, 0.5)
    ), url(/img/Milwaukeedowntown.jpg);
  }
  #auricular {
    background-image: linear-gradient(
        rgba(0, 0, 0, 0.5),
        rgba(0, 0, 0, 0.5)
    ), url(/img/sailboat.jpg);
  }
  #home, #auricular {

    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    display: table;
    height: 500px;
    position: relative;
    width: 100%;
     -webkit-background-size: cover;
     -moz-background-size: cover;
     -o-background-size: cover;
    background-size: cover;
    color:white;
    text-align: center;
    vertical-align: center;
  }

</style>