
<template>
  <div>
    <nav-menu></nav-menu>
    <registration-form></registration-form>
    <stripe-payment-form></stripe-payment-form>
  </div>
</template>

<script>
  import StripePaymentForm from "./registration/StripePaymentForm";
  import RegistrationForm from "./registration/RegistrationForm";
  import NavMenu from "./NavMenu";
  export default {
    name: "RegistrationPage",
    components: {NavMenu, RegistrationForm, StripePaymentForm},
  }
</script>

<style scoped>

</style>