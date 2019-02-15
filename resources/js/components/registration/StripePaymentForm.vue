
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

    ></vue-stripe-checkout>
    <button @click="checkout">Checkout</button>
  </div>
</template>

<script>
  export default {
    name: "StripePaymentForm",
    props: ['purchaserEmail'],
    data() {
      return {
        image: '/img/poca_logo.png',
        name: 'POCA Fest Registration',
        description: 'For all the POCA!',
        currency: '$',
        amount: 99999
      }
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
        console.log(token, args);
        Bus.$emit('stripe_done', {token,  args});
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