<template>

  <div>
    <h2>
      <slot name="heading"></slot>
    </h2>
    <p class="lead">
      <slot name="lead"></slot>
    </p>
    <p>
      <slot name="default"></slot>
    </p>
  </div>

</template>

<script>
  export default {
    name: "Description"
  }
</script>

<style scoped>

</style>