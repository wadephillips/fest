<template>
  <div>
    <vue-form-generator :schema="schema" :model="model" :options="formOptions">
    </vue-form-generator>
  </div>
</template>

<script>
  import VueFormGenerator from 'vue-form-generator/dist/vfg.js'
  import 'vue-form-generator/dist/vfg.css'
  import cleave from 'cleave.js'
  require('cleave.js/dist/addons/cleave-phone.us');
  require('cleave.js/dist/addons/cleave-phone.ca');

  export default {
    name: "AttendeeDetails",
    components: {
      "vue-form-generator": VueFormGenerator.component,
    },
    data() {
      return {
        model: {
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
        },
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
                  inputType: 'text',
                  label: 'Street Address',
                  model: 'address',
                  placeholder: '123 Any St.'
                },
                {
                  type: 'input',
                  inputType: 'text',
                  label: 'Suite or Unit',
                  model: 'suite',
                  placeholder: '#987'
                },
                {
                  type: 'input',
                  inputType: 'text',
                  label: 'Address 2',
                  model: 'address_2',
                  placeholder: ''
                },
                {
                  type: 'input',
                  inputType: 'text',
                  label: 'City',
                  model: 'city',
                  placeholder: 'Anytown'
                },
                {
                  type: "select",
                  label: "State or Province",
                  model: "state",
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
                // {
                //   type: 'input',
                //   inputType: '',
                //   label: '',
                //   model: '',
                //   placeholder: ''
                // },
               
              ]
            }
          ]
        }
      }
    },

  }
</script>

<style scoped>

</style>