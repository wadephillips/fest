<template>
  <div class="card">
    <div class="card-header bg-info">
        <span>{{this.decoratedName}}</span>
        <span v-if="this.presenter.credentials !== null && this.presenter.credentials !== ''">{{this.presenter.credentials}}</span>
    </div>
    <div class="card-body">
      <p class="card-text">{{this.presenter.bio}}</p>
    </div>
    <!--<div class="card-footer text-muted">-->
      <!--<span v-for="breakout in this.presenter.breakouts">{{breakout.title}}</span>-->
    <!--</div>-->
  </div>
</template>

<script>
  export default {
    name: "Presenter",
    props: ['presenter'],
    computed: {
      decoratedName() {
        let name = this.presenter.name;
        if (this.presenter.credentials) {
          name += ', '
        }
        return name;
      }
    }
  }
</script>

<style scoped>

</style>