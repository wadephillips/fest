<template>

  <div class="container">
    <form id="registrationForm" :action="postPath" method="post">
      <input type="hidden" name="_token" :value="csrf">

      <vue-form-generator :schema="schema" :model="model[0]" :options="formOptions">
      </vue-form-generator>
      <stripe-payment-form purchaserEmail="purchaserEmail"></stripe-payment-form>
    </form>
  </div>

</template>

<script>
  import VueFormGenerator from 'vue-form-generator/dist/vfg.js'
  import 'vue-form-generator/dist/vfg.css'
  import cleave from 'cleave.js'
  require('cleave.js/dist/addons/cleave-phone.us');
  require('cleave.js/dist/addons/cleave-phone.ca');



  export default {
    name: "RegistrationForm",
    components: {
      "vue-form-generator": VueFormGenerator.component,
    },
    // computed: {
    //   postPath(){
    //     return window.location.pathname;
    //   }
    // },
    data () {
      return {
        csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        postPath: window.location.pathname,
        model: [
          {
            id: 1,
            name: 'John Doe',
            password: 'J0hnD03!x4',
            skills: ['Javascript', 'VueJS'],
            email: 'john.doe@gmail.com',
            status: true,
            phone: '',

            emergencyContactName: '',
            emergencyContactRelationship: '',
            emergencyContactPhone: '',

            licenseNumber: '',
            licenseCountry: '',
            licenseState: '',




          },
          // {
          //   id: 2,
          //   name: 'Jane Doe',
          //   password: 'J0hnD03!x4',
          //   skills: ['VueJS'],
          //   email: 'jane.doe@gmail.com',
          //   status: false
          //
          // }
        ],

        schema: {
          groups: [
            {
              legend: 'Attendee Details',
              fields: [
                {
                  type: 'input',
                  inputType: 'text',
                  label: 'ID (disabled text field)',
                  model: 'id',
                  readonly: true,
                  disabled: true
                },
                {
                  type: 'input',
                  inputType: 'text',
                  label: 'Name',
                  model: 'name',
                  placeholder: 'Attendee name',
                  featured: true,
                  required: true
                },
                {
                  type: 'input',
                  inputType: 'email',
                  label: 'E-mail',
                  model: 'email',
                  placeholder: 'User\'s e-mail address',
                  validator: ['required','email']
                },
                {
                  type: 'cleave',
                  label: 'Phone',
                  model: 'phone',
                  cleaveOptions: {
                    phone: true,
                    phoneRegionCode: 'US'
                  },
                  placeholder: 'Attendee\'s phone number'
                },
                {
                  type: 'input',
                  inputType: '',
                  label: '',
                  model: '',
                  placeholder: ''
                },
                // {
                //   type: 'input',
                //   inputType: 'password',
                //   label: 'Password',
                //   model: 'password',
                //   min: 6,
                //   required: true,
                //   hint: 'Minimum 6 characters',
                //   validator: 'string'
                // }
              ]
            },
            {
              legend: 'Emergency Contact Info',
              fields: [
                {
                  type: 'input',
                  inputType: 'text',
                  label: 'Emergency Contact Name',
                  model: 'emergencyContactName',
                  // placeholder: 'A name',
                  featured: true,
                  required: true
                },
                {
                  type: 'cleave',
                  label: 'Emergency Contact Phone',
                  model: 'emergencyContactPhone',
                  cleaveOptions: {
                    phone: true,
                    phoneRegionCode: 'US'
                  },
                  required: true,
                  placeholder: 'Best phone number for contacting'
                },
                {
                  type: 'input',
                  inputType: 'text',
                  label: 'Relationship to Emergency Contact ',
                  model: 'emergencyContactRelationship',
                  required: true
                },
              ]
            },
            {
              legend: 'Acupuncture License Info',
              fields: [
                {
                  type: "select",
                  label: "State or Province",
                  model: "licenseState",
                  // required: true,
                  values: states,
                  // default: "en-US",
                  // validator: validators.required
                  selectOptions: {
                    noneSelectedText: "Select a state/province"
                  }
                },
                {
                  type: 'select',
                  label: 'Country',
                  model: 'licenseCountry',
                  values: countries,
                  selectOptions: {
                    noneSelectedText: "Select a country"
                  }
                },
                {
                  type: 'input',
                  inputType: 'text',
                  label: 'License Number',
                  model: 'licenseNumber',
                  placeholder: ''
                },
              ]
            }
          ]
        },

        formOptions: {
          validateAfterLoad: true,
          validateAfterChanged: true,
          validateAsync: true
        }
      }
    },
    methods: {

    },
    computed: {
      purchaserEmail() {
        return model[0].email;
      }
    },
    mounted() {
      let self = this;
      Bus.$on('stripe_done', (payload) => {
        $('#registrationForm').submit();
      });
    }
  }
</script>

<style scoped>

</style>