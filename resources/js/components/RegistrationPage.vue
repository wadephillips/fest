
<template>
  <div class="m-3">
    <div class="mb-4">
      <h1 class="h3 text-muted" v-if="this.presenter">Presenter Registration for {{event.name}}</h1>
      <h1 class="h3 text-muted" v-else>Register for {{event.name}}</h1>

      <h2 class="h5 text-muted">{{event.location_name}} - {{event.city}}</h2>

      <h3 class="h5 text-muted">{{ eventDates }}</h3>
    </div>

    <registration-form :event-name="event.name" :presenter="this.presenter" dusk="registration-form" ></registration-form>

    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <policy>
            <template slot="title">Cancellation Policy</template>
            <p>POCA Fest requires pre-registration and payment in full by the participant.</p>

            <p>For cancellations, following the refund schedule applies:</p>
            <p>Before September 1<sup>st</sup> - 100% refund</p>

            <p>September 1<sup>st</sup> to September 14<sup>th</sup> - 50 % refund</p>

            <p>September 15<sup>th</sup> onward - no refund</p>

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
.form-group label {
  font-weight: 500;
}
</style>