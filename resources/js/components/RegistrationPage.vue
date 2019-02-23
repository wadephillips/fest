
<template>
  <div>
    <h1>Register for {{event.name}}</h1>

    <h2>{{event.city}}</h2>
    <!--todo reformat with moment-->
    <h4>{{event.start}} to {{event.end}}</h4>
    <registration-form :event-name="event.name"></registration-form>
  </div>
</template>

<script>
  // import StripePaymentForm from "./registration/StripePaymentForm";
  import RegistrationForm from "./registration/RegistrationForm";
  import NavMenu from "./NavMenu";
  export default {
    name: "RegistrationPage",
    components: {NavMenu, RegistrationForm},
    props: ['event']
  }
</script>

<style scoped>

</style>