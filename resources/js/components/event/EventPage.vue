<template>
  <main>
    <!--Hero-->
    <info-section>
      <template slot="heading">
        <h1 class="text-center">{{event.name}}</h1>
      </template>

      <template slot="subheading">
        <h3 class="text-center">{{this.eventDates}}</h3>
      </template>

      <template slot="default">
        <div class="col-md">
          <p class="lead">{{ event.description}}</p>
        </div>
      </template>

    </info-section>

    <hr>
    <!--Location-->
    <info-section>
      <template slot="heading">
        <h2 class="text-center">Location</h2>

      </template>

      <template slot="default">
        <div class="col-md-6">
          <location-address
              :name="this.event.location_name"
              :address="this.event.address"
              :address_2="this.event.address_2"
              :suite="this.event.suite"
              :city="this.event.city"
              :state="this.event.state"
              :postal="this.event.postal"
          ></location-address>
        </div>
      </template>
      <template slot="image-right">
        <div class="col-md">
        <fest-map place-id="ChIJFY5ircKXBYgRXS2rAIsCc4Q" api-key="AIzaSyCSdbPjbn7KYWaFGl6Cy8EYD1l1YVCTGL8"></fest-map>
        </div>
      </template>
    </info-section>

    <hr>
    <!--Fees-->
    <info-section>

      <template slot="heading">
        <h2 class="text-center">Conference Fees</h2>
      </template>

      <template slot="default">
        <hr>
        <div class="col-md">
          <div class="text-center" v-for="fee in this.event.fees">
            <fee :fee="fee"></fee>
          </div>
        </div>
      </template>

    </info-section>

    <hr>
    <!--schedule-->
    <info-section>
      <template slot="heading">
        <h2 class="text-center">Conference Schedule</h2>
      </template>

      <schedule></schedule>
    </info-section>

    <hr>
    <!--Breakouts-->
    <info-section>
      <template slot="heading">
        <h2 class="text-center">Breakouts</h2>
      </template>

      <div class="card-columns">
        <breakout :breakout="breakout" :key="breakout.id" ey v-for="breakout in this.event.breakouts"></breakout>
      </div>

    </info-section>

    <hr>
    <!--Presenters-->
    <info-section>
      <template slot="heading">
        <h2 class="text-center">Presenters</h2>
      </template>
      <div class="card-columns">
        <presenter :presenter="presenter" :key="presenter.id" v-for="presenter in this.presenters"></presenter>
      </div>
    </info-section>
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
  }
</script>

<style scoped>

</style>