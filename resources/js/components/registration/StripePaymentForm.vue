
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
        @done="done"
        @opened="opened"
        @closed="closed"
        @canceled="canceled"
        id="stripeCheckoutForm"
    ></vue-stripe-checkout>
    <button type="button" class="btn btn-primary" id="checkout-button" dusk="checkout-button" @click="checkout">Checkout @ {{total}}</button>

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
        amount: this.total
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
    },
     methods: {
      async checkout () {
        // token - is the token object
        // args - is an object containing the billing and shipping address if enabled
        const { token, args } = await this.$refs.checkoutRef.open();
      },
      done ({token, args}) {
        // token - is the token object
        // args - is an object containing the billing and shipping address if enabled
        // console.log(token, args);


        let payload = {
          registrants: this.models,
          token: token,
          args: args,
          description: this.description,
          total: this.total, //todo set the total

        };
        let registration = axios.post(this.postPath, payload)
            .then( (response) => {
          //if successful
          if (response.status === 200) {
            // $(self.modalId).modal('hide'); todo
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
      },
      canceled () {
        // do stuff
      }
    }
  }
</script>

<style scoped>

</style>