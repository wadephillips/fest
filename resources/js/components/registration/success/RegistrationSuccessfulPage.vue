<template>
  <div class="container">
    <div class="row">
      <div class="col-sm">
        <hero>
          <template slot="heading">You're going to POCA Fest!</template>
          <template slot="lead">Thanks for registering, its going to be fun!</template>
          
          <template slot="action">
            <a id="poca-forums-btn" class="btn btn-primary"
               href="https://www.pocacoop.com/forums/viewforum/175/"
               role="button" dusk="poca-forums-button" >The POCA Fest Forum</a>

            <a id="pf-toronto-photos-btn" class="btn btn-outline-secondary" href="https://www.pocacoop.com/forums/viewthread/9088/" role="button" dusk="pf-toronto-pictures-button">Pictures from POCA Fest Toronto!</a>
          </template>
        </hero>

        <div class="row mb-4">
          <div class="col-md-8 offset-md-2">
            <description>
              Et! Sit augue augue, sagittis aliquet? Urna integer enim, lorem lacus vel sagittis? Penatibus duis, risus,
              dapibus magnis turpis in adipiscing eu elementum, proin risus? Sit et egestas! In mus porttitor, odio
              massa! Mauris dictumst eros vel, ultrices porttitor? Tempor odio, mattis eu! Elementum dignissim in, proin
              tincidunt nunc.
            </description>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
            <attendee-table :attendees="this.attendees" :total="this.payment.amount"></attendee-table>
          </div>
        </div>



        <div class="row">
          <div class="col-md-8 offset-md-2">
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
  </div>

</template>

<script>
  import Hero from "../../Hero";
  import Policy from "../../registration/success/Policy";
  export default {
    name: "RegistrationSuccessfulPage",
    components: { Hero, Policy},
    props: ['event', 'attendees', 'payment']
  }
</script>

<style scoped>

</style>