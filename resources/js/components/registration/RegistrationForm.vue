<template>

  <div class="container">
    <form @submit.prevent="handleSubmit" id="registrationForm" >
      <input type="hidden" name="_token" :value="csrf">

      <div v-for="model in formModels" :key="model.id">
        <attendee :key="model.id" :model="model"></attendee>
      </div>

      <div class="row">
        <div class="col-md-3">
          <button @click="addAttendee" type="button" class="btn btn-primary m-3" id="add-attendee-btn"
                  dusk='add-attendee-btn'>+ Add Attendee
          </button>


          <!--<vue-form-generator :schema="schema" :model="model[0]" :options="formOptions">-->
          <!--</vue-form-generator>-->

        </div>
        <div class="col"></div>
        <div class="col-md-3">
          <stripe-payment-form
              class="m-3"
              :purchaserEmail="purchaserEmail"
              :models="formModels"
              :postPath="postPath"
              :event-name="eventName"
              :total="total"
          ></stripe-payment-form>
        </div>
      </div>
      <div class="row">
        <div class="col-md-8 offset-md-2">
          <div v-show="this.form.errors.length > 0" class="alert alert-warning alert-dismissible fade show"
               role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <strong>There was a problem processing your charge:</strong>
            <ul>
              <li v-for="error in this.form.errors">{{error.message}}</li>
            </ul>
          </div>
        </div>
      </div>
    </form>
  </div>

</template>

<script>

  import Attendee from "./Attendee";
  import StripePaymentForm from "./StripePaymentForm";


  window.axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content')
  };

  export default {
    name: "RegistrationForm",
    components: {
      Attendee,
    },
    props: ['eventName'],
    data () {
      return {
        csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        postPath: window.location.pathname,
        attendees: 1,
        form: {
          errors: []
        },
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
        // console.log(payload);

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
        return this.formModels[0].email;
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

      Bus.$on('clearFormErrors', function () {
        self.form.errors = [];
      });

      Bus.$on('setFormErrors', function (e) {
        self.form.errors.push(e);
      });
    },

  }
</script>

<style scoped>

</style>