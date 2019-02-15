
<template>
  <div>
    <nav-menu></nav-menu>
    <registration-form></registration-form>
  </div>
</template>

<script>
  // import StripePaymentForm from "./registration/StripePaymentForm";
  import RegistrationForm from "./registration/RegistrationForm";
  import NavMenu from "./NavMenu";
  export default {
    name: "RegistrationPage",
    components: {NavMenu, RegistrationForm},
  }
</script>

<style scoped>

</style>