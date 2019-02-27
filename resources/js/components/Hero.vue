<template>
  <div class="jumbotron">
    <h1 class="display-4">
      <slot name="heading">Hello, world!</slot>
    </h1>

    <p class="lead">
      <slot name="lead"></slot>
    </p>

    <hr class="my-4">

    <p>
      <slot name="default"></slot>
    </p>

    <div>
      <slot name="action"></slot>
    </div>

  </div>
</template>

<script>
  export default {
    name: "Hero"
  }
</script>

<style scoped>

</style>