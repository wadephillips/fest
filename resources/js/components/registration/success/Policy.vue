<template>
  <div class="card">
    <div class="card-body">
      <h4 class="card-title" >
        <slot name="title">Standard Policy</slot>
      </h4>
      <p class="card-text" >
        <slot name="default">Et! Sit augue augue, sagittis aliquet? Urna integer enim, lorem lacus vel
        sagittis? Penatibus duis, risus, dapibus magnis turpis in adipiscing eu elementum, proin risus? Sit et egestas!
        In mus porttitor, odio massa! Mauris dictumst eros vel, ultrices porttitor? Tempor odio, mattis eu! Elementum
          dignissim in, proin tincidunt nunc
        </slot>
      </p>
    </div>
  </div>
</template>

<script>
  export default {
    name: "Policy"
  }
</script>

<style scoped>

</style>