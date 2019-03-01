
<template>
  <div>
    <div class="">
    <vue-stripe-checkout
        ref="checkoutRef"
        :image="image"
        :name="name"
        :description="description"
        :currency="currency"
        :amount="amount"
        :allow-remember-me="false"
        :email="purchaserEmail"
        :zip-code="true"
        @checkout="checkout($event)"
        @done="done"
        @opened="opened"
        @closed="closed"
        @canceled="canceled"
        id="stripeCheckoutForm"
    ></vue-stripe-checkout>

    <button v-show="!this.form.submitted" type="button" class="btn btn-primary" id="checkout-button" dusk="checkout-button" @click="checkout" :disabled="this.displayTotal == 0 || (this.form.busy && !this.form.submitted)">Pay and Register for ${{displayTotal}}</button>
    <button v-show="this.form.submitted" class="btn btn-success btn-lg"><i class="far fa-3x fa-spinner fa-spin"></i> <h3>Processing...</h3></button>

    </div>



  </div>
</template>

<script>
  export default {
    name: "StripePaymentForm",
    props: ['purchaserEmail', 'models', 'postPath', 'eventName', 'total'],
    data() {
      return {
        form: {
          busy: false,
          submitted: false,
        },
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
          this.form.busy = true;
          const { token, args } = await this.$refs.checkoutRef.open();
        } else {
          this.formValidationsResponse = 0;
          Bus.$emit('validateForms', $event);
        }

      },
      done ({token, args}) {
        // token - is the token object
        // args - is an object containing the billing and shipping address if enabled

        this.form.busy = true;
        this.form.submitted = true;

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
          if (response.status === 201) {
            // $(self.modalId).modal('hide');
            window.location = response.data.redirect;
          }

          if (response.status === 402) {
            // console.log('402');
            // console.log(response);
            // console.log(response.data);
            Bus.$emit('setFormErrors', response.data);
          }
          // return response.data.note;
        }).catch( (response) => {
              // console.log('error');
              // console.log(response);
              // console.log(response.data);
              Bus.$emit('setFormErrors', response.data);
        });
        // Bus.$emit('stripe_done', {token,  args});
        // do stuff...
      },
       //todo get rid of this method
       // testSubmit () {
       //   // token - is the token object
       //   // args - is an object containing the billing and shipping address if enabled
       //
       //   let token = {
       //          "id": "tok_chargeDeclined",
       //          "object": "token",
       //          "card": {
       //            "id": "tok_chargeDeclined",
       //            "object": "card",
       //            "address_city": "Anytown",
       //            "address_country": "US",
       //            "address_line1": "123 any st.",
       //            "address_line1_check": "pass",
       //            "address_line2": null,
       //            "address_state": null,
       //            "address_zip": "99501",
       //            "address_zip_check": "pass",
       //            "brand": "Visa",
       //            "country": "US",
       //            "cvc_check": "pass",
       //            "dynamic_last4": null,
       //            "exp_month": 11,
       //            "exp_year": 2020,
       //            "funding": "credit",
       //            "last4": "0002",
       //            "metadata": {},
       //            "name": "jjones@example.com",
       //            "tokenization_method": null
       //          },
       //          "client_ip": "173.244.44.41",
       //          "created": 1550261813,
       //          "email": "jjones@example.com",
       //          "livemode": false,
       //          "type": "card",
       //          "used": false
       //        };
       //
       //   let args = {};
       //
       //
       //
       //   this.form.submitted = true;
       //
       //   let payload = {
       //     registrants: this.models,
       //     token: token,
       //     args: args,
       //     description: this.description,
       //     total: this.total,
       //
       //   };
       //   let registration = axios.post(this.postPath, payload)
       //       .then( (response) => {
       //         //if successful
       //         if (response.status === 201) {
       //           // $(self.modalId).modal('hide');
       //           window.location = response.data.redirect;
       //         }
       //
       //         // if (response.status === 402) {
       //         //   console.log('402');
       //         //   console.log(response);
       //         //   console.log(response.data);
       //         //   Bus.$emit('setFormErrors', response.data);
       //         // }
       //         // return response.data.note;
       //       }).catch( (error) => {
       //         if (error.response) {
       //           // The request was made and the server responded with a status code
       //           // that falls out of the range of 2xx
       //           // console.log(error.response.data.error.message);
       //           // console.log(error.response.status);
       //           // console.log(error.response.headers);
       //           Bus.$emit('setFormErrors', error.response.data.error);
       //         } else if (error.request) {
       //           // The request was made but no response was received
       //           // `error.request` is an instance of XMLHttpRequest in the browser and an instance of
       //           // http.ClientRequest in node.js
       //           console.log(error.request);
       //           let err = {message: 'There was a connection error, please try resubmitting your registration.'}
       //           Bus.$emit('setFormErrors', err);
       //
       //         } else {
       //           // Something happened in setting up the request that triggered an Error
       //           console.log('Error', error.message);
       //         }
       //         console.log(error.config);
       //
       //       });
       //
       // },
      opened () {
        // do stuff
      },
      closed () {
        // do stuff
        this.resetValidationChecks();
        this.form.busy = false;
      },
      canceled () {
        this.resetValidationChecks();
      },
       allFormsValid() {
         return Object.keys(this.formsValid).every( k => this.formsValid[k] === true);
       },
       resetValidationChecks() {
         Bus.$emit('clearFormErrors');
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