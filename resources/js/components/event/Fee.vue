<template>
  <p><strong>{{this.fee.label}} :</strong> {{this.prices}}{{ this.additonalInfo}}</p>
</template>

<script>
  export default {
    name: "Fee",
    props: ['fee'],
    computed: {
      prices() {
        let price = '$' + this.fee.amount_min;

        if (this.fee.amount_max > 0  && this.fee.amount_max > this.fee.amount_min ) {
          price += ' - $' + this.fee.amount_max;
        }
        return price;
      },
      additonalInfo() {
        let info = '';
        if (this.fee.info !== null  && this.fee.info !== '') {
          info += ' - ' + this.fee.info;
        }
        return info;
      }
    }
  }
</script>

<style scoped>

</style>