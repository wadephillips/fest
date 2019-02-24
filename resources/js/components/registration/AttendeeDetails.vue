<template>
  <div>
    <vue-form-generator @model-updated="formUpdated"  tag="div" :schema="schema" :model="model" :options="formOptions">
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
    props:['model-id'],
    data() {
      return {
        formOptions: {
          validateAfterLoad: false,
          validateAfterChanged: true,
          fieldIdPrefix: 'attendee_'
        },
        // formOptions: optionsIn
        model: {
          id: null,
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
                  label: 'Name',
                  model: 'name',
                  placeholder: 'Jane Doe',
                  required: true,
                  styleClasses: ['col-md']
                },
                {
                  type: 'input',
                  inputType: 'email',
                  label: 'E-mail',
                  model: 'email',
                  placeholder: 'jdoe@gmail.com',
                  validator: ['required', 'email'],
                  required: true,
                  styleClasses: ['col-md-6'],
                  id: 'email'
                },
                {
                  type: 'cleave',
                  label: 'Phone',
                  model: 'phone',
                  cleaveOptions: {
                    phone: true,
                    phoneRegionCode: 'US'
                  },
                  placeholder: '551-555-5555',
                  required: true,
                  styleClasses: ['col-md-6']
                },
              ],
            },
            {
              styleClasses: ['field-row'],
              fields: [
                {
                  type: 'input',
                  inputType: 'text',
                  label: 'Street Address',
                  model: 'address',
                  placeholder: '123 Any St.',
                  required: true,
                  styleClasses: [ 'col-md-8'],
                  id: 'address'
                },
                {
                  type: 'input',
                  inputType: 'text',
                  label: 'Suite or Unit',
                  model: 'suite',
                  placeholder: '#987',
                  styleClasses: [ 'col-md-4'],
                  id: 'suite'

                },
              ]
            },
            {
              fields: [
                {
                  type: 'input',
                  inputType: 'text',
                  label: 'Address 2',
                  model: 'address_2',
                  placeholder: '',
                  styleClasses: ['col-md'],
                  id: 'address_2'
                },
              ]
            },
            {
              fields: [
                {
                  type: 'input',
                  inputType: 'text',
                  label: 'City',
                  model: 'city',
                  placeholder: 'Anytown',
                  required: true,
                  styleClasses: [ 'col-md-6'],
                },
                {
                  type: "select",
                  label: "State",
                  model: "state",
                  // required: true,
                  values: states,
                  // default: "en-US",
                  // validator: validators.required
                  selectOptions: {
                    noneSelectedText: "Select a state/province"
                  },
                  styleClasses: [ 'col-md-3'],
                  required: true
                },
                {
                  type: 'input',
                  inputType: 'text',
                  label: 'Postal Code',
                  model: 'postal',
                  placeholder: '97213',
                  styleClasses: [ 'col-md-3'],
                  required: true,
                  id: 'postal'

                },
              ]
            },
            {
              fields: [
                {
                  type: 'select',
                  label: 'Country',
                  model: 'country',
                  values: countries,
                  selectOptions: {
                    noneSelectedText: "Select a country"
                  },
                  required: true,
                  styleClasses: [ 'col-md-4', 'float-right'],
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
    created(){
      let self = this;

      this.model.id = this.modelId;
      this.formOptions.fieldIdPrefix += this.modelId + '_';

    },
    methods: {
      formUpdated: function () {
        Bus.$emit('updateAttendeeModel', this.model);
      },
    }

  }
</script>

<style scoped>

</style>