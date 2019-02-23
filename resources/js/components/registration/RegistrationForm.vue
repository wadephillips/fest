<template>

  <div class="container">
    <form @submit.prevent="handleSubmit" id="registrationForm" >
      <input type="hidden" name="_token" :value="csrf">

      <div v-for="model in formModels">
        <attendee :key="model.id" :model="model"></attendee>
      </div>

      <button @click="addAttendee" type="button" class="btn btn-primary">+</button>


      <!--<vue-form-generator :schema="schema" :model="model[0]" :options="formOptions">-->
      <!--</vue-form-generator>-->
      <stripe-payment-form
          :purchaserEmail="formModels[0].email"
          purchaserEmail="purchaserEmail"
          :models="formModels"
          :postPath="postPath"
          :event-name="eventName"
          :total="total"
      ></stripe-payment-form>
    </form>
  </div>

</template>

<script>
  // import VueFormGenerator from 'vue-form-generator/dist/vfg.js'
  // import 'vue-form-generator/dist/vfg.css'
  // import cleave from 'cleave.js'
  import Attendee from "./Attendee";
  import StripePaymentForm from "./StripePaymentForm";
  // require('cleave.js/dist/addons/cleave-phone.us');
  // require('cleave.js/dist/addons/cleave-phone.ca');


  window.axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content')
  };

  export default {
    name: "RegistrationForm",
    components: {
      Attendee,
      // "vue-form-generator": VueFormGenerator.component,
    },
    props: ['eventName'],
    data () {
      return {
        csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        postPath: window.location.pathname,
        attendees: 1,
        formModels: [
          {
            id: 0,
            name: '',
            email: '',
            phone: '',
            address: '',
            address_2: '',
            suite: '',
            city: '',
            state: '',
            postal: '',
            country: '',


            emergency_contact_name: '',
            emergency_contact_relationship: '',
            emergency_contact_phone: '',

            license_number: '',
            license_country: '',
            license_state: '',

            amount: 0,
            modifiers: {}

          },

        ],
        processorInfo: {},

        formOptions: {
          validateAfterLoad: true,
          validateAfterChanged: true,
          validateAsync: true
        }
      }
    },
    methods: {
      handleSubmit() {
        let payload = {
          models: this.formModels,
          token: this.processorInfo.token,
          args: this.processorInfo.args
        }
        // let note = axios.post(this.postPath,);
        console.log(payload);

        //     .then( (response) => {
        //   //if successful
        //   if (response.status === 200) {
        //     // $(self.modalId).modal('hide'); todo
        //     Bus.$emit('noteUpdate', response.data.note);
        //   }
        //   return response.data.note;
        // });

      },
      addAttendee() {
        this.attendees = parseInt(this.attendees) + 1;
        let index = this.attendees - 1;
        this.formModels.push({
          "id": index,
          "name": "",
          "email": "",
          "phone": "",
          "address": "",
          "address_2": "",
          "suite": "",
          "city": "",
          "state": "",
          "postal": "",
          "country": "",
          "emergency_contact_name": "",
          "emergency_contact_relationship": "",
          "emergency_contact_phone": "",
          "license_number": "",
          "license_country": "",
          "license_state": "",
          "amount": 0,
          "modifiers": {}
        });

        let wildcardSelector = 'attendee_' + index + '_rs';
        $('label[for^="' + wildcardSelector + '"]').each(function() { $(this).parent().hide()});
      }
    },
    computed: {
      purchaserEmail() {
        return formModels[0].email;
      },
      total() {
        let total = 0;
        this.formModels.forEach((model) => {
          total += model.amount;
        });
        return total;
      }
    },
    mounted() {
      let self = this;
      let modelId = 0;
      Bus.$on('stripe_done', (payload) => {

        // put Stripe token object in data
        self.processorInfo.token = payload.token;
        //put stripe args object in data
        self.processorInfo.args = payload.args;

        $('#registrationForm').submit();
      });

      Bus.$on('updateAttendeeModel', (payload) => {
        modelId = payload.id;
        // delete payload.id;
        for (let k in payload) {
          if (k !== 'id' && payload.hasOwnProperty(k)) {
            self.formModels[modelId][k] = payload[k];
          }
        }
      });
    },

  }
</script>

<style scoped>

</style>