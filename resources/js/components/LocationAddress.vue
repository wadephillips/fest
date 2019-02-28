<template>
  <address>
    <h4>Address:</h4>
    <span v-if="this.name">{{this.name}}</span><br v-if="this.name"/>
    <span v-if="this.address">{{this.address}} <span v-if="this.suite">{{ this.suite}}</span></span><br v-if="this.address"/>
    <span v-if="this.address_2">{{this.address_2}}</span><br v-if="this.address"/>
    <span>{{this.city}}, {{this.state}} {{this.postal}}</span>
  </address>
</template>

<script>
  export default {
    name: "location-address",
    props: [
        'name',
      'address',
      'address_2',
      'suite',
      'city',
      'state',
      'postal',
    ]
  }
</script>

<style scoped>

</style>