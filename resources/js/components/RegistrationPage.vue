
<template>
  <div class="m-3">
    <h1>Register for {{event.name}}</h1>

    <h2>{{event.city}}</h2>
    <!--todo reformat with moment-->
    <h4>{{ eventDates }}</h4>
    <registration-form :event-name="event.name"></registration-form>
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <policy>
            <template slot="title">Cancellation Policy</template>
            3 day passes- a full refund minus a credit card processing fee ($5) is available until July 10th.

            After July 10th if we can fill your space with another registrant you will receive a full refund minus a
            credit card processing fee.  If we cannot fill the spot you will be refunded 45% of your registration fee.  

            Saturday day-passes are fully refundable until July 10th.  After that they are 45% refundable.
          </policy>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import RegistrationForm from "./registration/RegistrationForm";
  import NavMenu from "./NavMenu";
  import moment from 'moment';
  import Policy from './registration/success/Policy';

  export default {
    name: "RegistrationPage",
    components: {NavMenu, RegistrationForm, Policy},
    props: ['event'],
    computed: {
      eventDates() {
        let eventDatesStr = "";
        let start = moment(this.event.start);
        let end = moment(this.event.end);
        if (end.diff(start, "days") >= 1) {
          eventDatesStr = start.format("dddd, MMMM Do, YYYY") + "  >>  " + end.format("dddd, MMMM Do, YYYY");
        } else {
          eventDatesStr = start.format("dddd MMM Do, YYYY");
        }
        return eventDatesStr;
      }
    }
  }
</script>

<style scoped>

</style>