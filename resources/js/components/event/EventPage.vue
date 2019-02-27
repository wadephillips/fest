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
        <h1 class="text-center">Conference Fees</h1>
      </template>

      <template slot="default">
        <hr>
        <div class="col-md">
          <p class="lead">{{ event.description}}</p>
        </div>
      </template>

    </info-section>
  </main>
</template>

<script>
  import InfoSection from './InfoSection'
  import {dates} from "../mixins/dates";

  export default {
    name: "EventPage",
    props: ['event', 'presenters'],
    components: {InfoSection},
    mixins: [dates]
  }
</script>

<style scoped>

</style>