<template>
  <nav   class="navbar sticky-top bg-secondary justify-content-center">
      <a class="nav-link" v-for="link in this.linkObjects" :key="link.a" :href="link.a" :class="link.styleClasses">{{link.description}}</a>

  </nav>
</template>

<script>
  export default {
    name: "NavMenu",
    props: ['linkObjects']
  }
</script>

<style scoped>

</style>