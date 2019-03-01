<template>
  <div class="card">
    <div class="card-header">
      {{ this.breakout.title }}
    </div>
    <div class="card-body">
      <p class="card-title">
        {{this.breakout.start}}
        <span v-if="this.breakout.end !== '' || this.breakout.end !== null"> to {{ this.breakout.end}}</span>
        <span> on {{this.breakout.date}}</span>

      </p>
      <p class="card-title"><span> At {{ this.breakout.location }}</span></p>
      <p class="card-text">{{ this.breakout.description }}</p>
    </div>
    <div class="card-footer text-muted">
      <span><strong>Presenters:</strong></span>
      <span v-for="(presenter, key, i) in this.breakout.presenters">{{presenter.name}}<span v-if="i != Object.keys(breakout.presenters).length - 1">, </span></span>
    </div>
  </div>
</template>

<script>
  import moment from 'moment';
  export default {
    name: "Breakout",
    props: ['breakout']
  }
</script>

<style scoped>

</style>