<template>
  <div class="container" :style="styles">
    <slot name="heading"></slot>
    <slot name="subheading"></slot>
    <div class="row">
      <slot name="image-left"></slot>
      <slot name="default"></slot>
      <slot name="image-right"></slot>
    </div>
  </div>
</template>

<script>
  export default {
    name: "InfoSection",
    computed: {
      styles() {
        return 'color:'+ this.color +';';
      }
    }
  }
</script>

<style scoped>

</style>