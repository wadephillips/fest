<template>
  <div>
    <div class="">
      <vue-stripe-checkout
          :allow-remember-me="false"
          :amount="total"
          :currency="currency"
          :description="description"
          :email="purchaserEmail"
          :image="image"
          :name="name"
          :zip-code="true"
          @canceled="canceled"
          @checkout="checkout($event)"
          @closed="closed"
          @done="done"
          @opened="opened"
          id="stripeCheckoutForm"
          ref="checkoutRef"
      ></vue-stripe-checkout>

      <button :disabled="this.displayTotal == 0 || (this.form.busy && !this.form.submitted)" @click="checkout" class="btn btn-primary" dusk="checkout-button"
              id="checkout-button" type="button"
              v-show="!this.form.submitted">Pay and Register for
        ${{displayTotal}}
      </button>
      <button class="btn btn-success btn-lg" v-show="this.form.submitted"><i class="far fa-3x fa-spinner fa-spin"></i>
        <h3>Processing...</h3></button>

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
      async checkout($event) {
        // console.log('now');
        // token - is the token object
        // args - is an object containing the billing and shipping address if enabled

        //fire event
        Bus.$emit('validateForms', $event);

        //wait for all the responses back

        //if there aren't any errors then we should show stripe form
        let requiredChecks = 4 * this.models.length;
        if (this.formValidationsResponse >= requiredChecks && this.allFormsValid()) {
          // //else tell them that the form has errors
          this.resetValidationChecks();
          this.form.busy = true;
          const {token, args} = await this.$refs.checkoutRef.open();
        } else {
          this.formValidationsResponse = 0;
          Bus.$emit('validateForms', $event);
        }

      },
      done({token, args}) {
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
            .then((response) => {
              //if successful
              this.form.busy = false;
              this.form.submitted = false;
              //todo deal with the other situations.
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
            }).catch((response) => {
              // console.log('error');
              // console.log(response);
              // console.log(response.data);
              Bus.$emit('setFormErrors', response.data);
            });

      },

      opened() {
        // do stuff
      },
      closed() {
        // do stuff
        this.resetValidationChecks();
        this.form.busy = false;
      },
      canceled() {
        this.resetValidationChecks();
      },
      allFormsValid() {
        return Object.keys(this.formsValid).every(k => this.formsValid[k] === true);
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
        if (this.formValidationsResponse >= 4 && this.allFormsValid()) {
          this.checkout();
        }
      });
    }
  }
</script>

<style scoped>

</style>