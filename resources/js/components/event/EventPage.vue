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
          <h2 class="text-center py-3 mt-5">{{this.eventDates}}</h2>
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
          <h2 class="text-center text-muted">Theme</h2>
        </template>
        <template slot="subheading">
          <h3 class="text-center h1">Endurance</h3>
        </template>
        <template slot="image-left">
          <div class="col-md-6">
            <img alt="" class="img-responsive" src="/img/chair.svg"/>
          </div>
        </template>
        <template slot="default">
          <div class="col-md-6 text-center pt-4"><p class="lead">By the time that this POCAfest happens Community Acupuncture will be 17.5 years old.</p>
            <p>No longer are we just the new, weird, revolutionary, disruptive movement that we started out as. We still are all those things but in addition we've been around to the point where CA is a well known branch of Acupuncture. </p>
            <p>That also means that we have a bunch of clinics that are way past their 10th birthdays and are thinking of things besides starting up like developing a succession plan, paying ourselves adequately, and hiring. Many of the breakout sessions this weekend will touch on such topics.</p>
            <p>In addition Jeff Levin, co-owner of Oakland Acupuncture Project will provide the keynote speech, <strong><em>"Chronic Pain, Endurance, and the Future of the Acupuncture Profession"</em></strong>. Please join us as we discuss and solve common issues that we all face. </p></div>
        </template>
      </info-section>

      <hr>
      <!--info-section id="auricular">
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
      <hr-->
      <!--Location-->
      <info-section id="location">
        <template slot="heading">
          <h2 class="text-center my-3 text-muted">Location</h2>

        </template>

        <template slot="default">
          <div class="col-md-6">
            <p class="lead">
              POCA Fest will be returning to the <a href="https://naturebridge.org/retreat-space/golden-gate">Headlands Institute</a> in the Marin Headlands.</p>

            <p>
              The Headlands Institute is a beautiful historic military camp located on the beach of the Pacific Ocean.</p>
            <p>It’s conveniently located just 22 miles from San Francisco International Airport or 30 miles from Oakland International Airport. Housing for the event will be onsite in dorm-style accommodations, with all meals provided in the dining hall.
            </p>

            <location-address
                :address="this.event.address"
                :address_2="this.event.address_2"
                :city="this.event.city"
                :name="this.event.location_name"
                :postal="this.event.postal"
                :state="this.event.state"
                :suite="this.event.suite"
            ></location-address>
          </div>
        </template>
        <template slot="image-right">
          <div class="col-md">
            <fest-map api-key="AIzaSyCSdbPjbn7KYWaFGl6Cy8EYD1l1YVCTGL8"
                      place-id="ChIJua9GxYqFhYARTCRipeBx4T8"></fest-map>
          </div>
        </template>
      </info-section>

      <hr>
      <!--Fees-->
      <info-section id="fees">

        <template slot="heading">
          <h2 class="text-center my-3 text-muted">Conference Fees</h2>
        </template>

        <template slot="default">
          <!--<hr>-->
          <div class="col-md-8 offset-md-2">
            <div class="text-center" v-for="fee in this.event.fees">
              <fee :fee="fee"></fee>
            </div>

          </div>
        </template>

        <!--<template slot="image-right">-->
          <!--<div class="col-md">-->
            <!--<div class="card bg-light border-light">-->
              <!--<div class="card-body">-->
                <!--<h4 class="card-title">Acu-Market Scholarship</h4>-->
                <!--<p class="card-text">Do you want to attend POCA Fest in Mukwonago, WI this Spring but can’t afford it?</p>-->
                <!--<p>Well you may be in luck! This year Acu-Market has sponsored our POCA Fest and is sending two lucky comrades to POCA Fest for FREE! That’s right, the fest including your lodging and meals are included. <em>POCA Memebers only!</em></p>-->
                <!--<p class="card-text"><small class="text-muted">Application deadline is Sunday, April 28, 2019. Two winners-->
                  <!--will be selected on Wednesday, May 1, 2019.</small></p>-->
                <!--<a href="https://forms.gle/c4WfcTnHA42Z1pRJ6" class="btn btn-outline-primary">Apply for the Acu-Market Scholarship</a>-->
              <!--</div>-->
            <!--</div>-->
          <!--</div>-->
        <!--</template>-->

      </info-section>

      <hr>
      <!--schedule-->
      <info-section id="schedule">
        <template slot="heading">
          <h2 class="text-center text-muted">Conference Schedule</h2>
        </template>

        <schedule></schedule>
      </info-section>

      <hr>
      <!--Breakouts-->
      <info-section id="breakouts">
        <template slot="heading">
          <h2 class="text-center text-muted">Breakouts</h2>
        </template>

        <div class="card-columns">
          <breakout :breakout="breakout" :key="breakout.id" v-for="breakout in this.event.breakouts"></breakout>
        </div>

      </info-section>

      <hr>
      <!--Presenters-->
      <info-section id="presenters">
        <template slot="heading">
          <h2 class="text-center text-muted">Presenters</h2>
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
          // {
          //   a: '#auricular',
          //   description: 'Auricular Certification',
          //   styleClasses: 'nav-link'
          // },
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
        rgba(0, 0, 0, 0.35),
        rgba(0, 0, 0, 0.5)
    ), url(/img/golden-gate.jpg);
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