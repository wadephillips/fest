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
            <attendee-table :attendees="attendees" total="payment.total"></attendee-table>
          </div>
        </div>



        <div class="row">
          <div class="col-md-8 offset-md-2">
            <policy>
              <template slot="title">Cancellation Policy</template>
              3 day passes- a full refund minus a credit card processing fee ($5) is available until July 10th.

              After July 10th if we can fill your space with another registrant you will receive a full refund minus a credit card processing fee.  If we cannot fill the spot you will be refunded 45% of your registration fee.  

              Saturday day-passes are fully refundable until July 10th.  After that they are 45% refundable.
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
    components: { Hero, Policy}
  }
</script>

<style scoped>

</style>