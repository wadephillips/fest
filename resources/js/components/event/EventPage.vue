<template>
  <main>
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

    <info-section>

      <template slot="heading">
        <h2 class="text-center">Conference Fees</h2>
      </template>

      <template slot="default">
        <hr>
        <div class="col-md">
          <div v-for="fee in this.event.fees" class="text-center">
            <fee :fee="fee"></fee>
          </div>
        </div>
      </template>

    </info-section>

    <info-section>
      <template slot="heading">
        <h2 class="text-center">Presenters</h2>
      </template>
      <div class="card-columns">
        <presenter v-for="presenter in this.presenters" :presenter="presenter"></presenter>
      </div>
    </info-section>
  </main>
</template>

<script>
  import InfoSection from './InfoSection'
  import {dates} from "../mixins/dates";
  import Fee from './Fee'
  import Presenter from "./Presenter";

  export default {
    name: "EventPage",
    props: ['event', 'presenters'],
    components: {Presenter, InfoSection, Fee},
    mixins: [dates]
  }
</script>

<style scoped>

</style>