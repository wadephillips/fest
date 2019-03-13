
<template>
  <div class="m-3">
    <h1 v-if="this.presenter">Presenter Registration for {{event.name}}</h1>
    <h1 v-else>Register for {{event.name}}</h1>

    <h3>{{event.location_name}} - {{event.city}}</h3>

    <h4>{{ eventDates }}</h4>

    <registration-form :event-name="event.name" dusk="registration-form"></registration-form>

    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <policy>
            <template slot="title">Cancellation Policy</template>
            <p>POCA Fest requires pre-registration and payment in full by the participant.</p>

            <p>For cancellations, following the refund schedule applies:</p>
            <p>Up to 30 days prior to POCA Fest (April 18th)- 100% refund</p>

            <p>29 to 14 days prior to POCA Fest (April 19-May 3rd)- 50 % refund</p>

            <p>13 days or less (after May 4th on)- no refund</p>

            <p>Refunds will be issued within 30 days.</p>
          </policy>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import RegistrationForm from "./registration/RegistrationForm";
  import NavMenu from "./NavMenu";
  import Policy from './registration/success/Policy';
  import {dates} from "./mixins/dates";

  export default {
    name: "RegistrationPage",
    components: {NavMenu, RegistrationForm, Policy},
    props: ['event', 'presenter'],
    mixins: [dates],
  }
</script>

<style scoped>

</style>