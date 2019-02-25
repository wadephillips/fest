
<template>
  <div>
    <vue-stripe-checkout
        ref="checkoutRef"
        :image="image"
        :name="name"
        :description="description"
        :currency="currency"
        :amount="amount"
        :allow-remember-me="false"
        :email="purchaserEmail"
        @checkout="checkout($event)"
        @done="done"
        @opened="opened"
        @closed="closed"
        @canceled="canceled"
        id="stripeCheckoutForm"
    ></vue-stripe-checkout>
    <button type="button" class="btn btn-primary" id="checkout-button" dusk="checkout-button" @click="checkout">Checkout @ ${{displayTotal}}</button>

  </div>
</template>

<script>
  export default {
    name: "StripePaymentForm",
    props: ['purchaserEmail', 'models', 'postPath', 'eventName', 'total'],
    data() {
      return {
        image: '/img/poca_logo.png',
        name: 'POCA Fest Registration',
        // description: 'For all the POCA!',
        currency: 'USD',
        amount: this.total,
        formsValid: {
          attendeeDetails: false,
          emergencyContact: false,
          acupunctureLicense: false,
          pocaFestOptions: false,

        },
        formValidationsResponse: 0
      }
    },
    computed: {
      attendeeCount() {
        return this.models.length;
      },
      description() {

        let description = 'Register ' + this.attendeeCount;
        let noun = (this.attendeeCount > 1) ? ' attenedees ' : ' attendee ';
        description += noun + 'for ' + this.eventName;
        return description;
      },
      displayTotal() {
        return this.total / 100;
      }
    },
     methods: {
      async checkout ($event) {
        // console.log('now');
        // token - is the token object
        // args - is an object containing the billing and shipping address if enabled

        //fire event
        Bus.$emit('validateForms', $event);

        //wait for all the responses back

        //if there aren't any errors then we should show stripe form
        let requiredChecks = 4 * this.models.length;
        if (this.formValidationsResponse >= requiredChecks  && this.allFormsValid()){
          // //else tell them that the form has errors
          this.resetValidationChecks();
          const { token, args } = await this.$refs.checkoutRef.open();
        } else {
          this.formValidationsResponse = 0;
          Bus.$emit('validateForms', $event);
        }

      },
      done ({token, args}) {
        // token - is the token object
        // args - is an object containing the billing and shipping address if enabled


        let payload = {
          registrants: this.models,
          token: token,
          args: args,
          description: this.description,
          total: this.total,

        };
        let registration = axios.post(this.postPath, payload)
            .then( (response) => {
          //if successful
          if (response.status === 200) {
            // $(self.modalId).modal('hide');
            console.log(response);
          }
          // return response.data.note;
        });
        // Bus.$emit('stripe_done', {token,  args});
        // do stuff...
      },
      opened () {
        // do stuff
      },
      closed () {
        // do stuff
        this.resetValidationChecks();
      },
      canceled () {
        this.resetValidationChecks();
      },
       allFormsValid() {
         return Object.keys(this.formsValid).every( k => this.formsValid[k] === true);
       },
       resetValidationChecks() {
         this.formValidationsResponse = 0;
         this.formsValid = {
           attendeeDetails: false,
           emergencyContact: false,
           acupunctureLicense: false,
           pocaFestOptions: false,

         };
       }
    },
    mounted() {
      let self = this;

      Bus.$on('subFormValidated', function (payload) {
        self.formValidationsResponse += 1
        let key = Object.keys(payload)[0];
        self.formsValid[key] = payload[key];
        if (this.formValidationsResponse >= 4  && this.allFormsValid()){
          this.checkout();
        }
      });
    }
  }
</script>

<style scoped>

</style>