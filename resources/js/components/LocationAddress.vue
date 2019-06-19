<template>
  <address>

    <span v-if="this.name" class="h4">{{this.name}}</span><br v-if="this.name"/>
    <span v-if="this.address" class="text-muted">{{this.address}} <span v-if="this.suite" class="text-muted">{{ this.suite}}</span></span><br v-if="this.address"/>
    <span v-if="this.address_2" class="text-muted">{{this.address_2}}</span><br v-if="this.address_2"/>
    <span class="text-muted">{{this.city}}, {{this.state}} {{this.postal}}</span>
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