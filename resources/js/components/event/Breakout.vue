<template>
  <div class="card">
    <div class="card-header">
      {{ this.breakout.title }}
    </div>
    <div class="card-body">
      <p class="card-title" v-if="this.breakout.start">
        {{this.formatedTime(this.breakout.start)}}
        <span v-if="this.breakout.end !== '' || this.breakout.end !== null"> to {{ this.formatedTime(this.breakout.end)}}</span>
        <span> on {{this.formatedDate(this.breakout.date)}}</span>

      </p>
      <p class="card-title" v-if="this.breakout.location"><em> At {{ this.breakout.location }}</em></p>
      <p class="card-text">{{ this.breakout.description }}</p>
    </div>
    <div class="card-footer text-muted">
      <span><strong>Presenters:</strong></span>
      <span v-for="(presenter, key, i) in this.breakout.presenters">{{presenter.name}}<span v-if="key !== Object.keys(breakout.presenters).length - 1">, </span></span>
    </div>
  </div>
</template>

<script>
  import moment from 'moment';
  export default {
    name: "Breakout",
    props: ['breakout'],
    data() {
      return {
        dateFormat: "ddd, MMM Do",
        timeFormat: "h:mm A"
      }
    },
    methods: {
      formatedDate(date) {
        return moment(date).format(this.dateFormat);
      },
      formatedTime(time) {
        let dateTime = this.breakout.date + " " + time
        return moment(dateTime).format(this.timeFormat);
      }
    }
  }
</script>

<style scoped>

</style>