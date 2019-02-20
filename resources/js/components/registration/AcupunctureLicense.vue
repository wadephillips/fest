<template>
  <div>
    <div class="form-group">
      <span class="switch switch-sm">
        <input v-model="acupuncturist" type="checkbox" class="switch" id="acupuncturist-switch">
        <label for="acupuncturist-switch">Acupuncturist</label>
      </span>
    </div>
    <vue-form-generator v-show="acupuncturist" :model="model" :options="formOptions" :schema="schema">
    </vue-form-generator>
  </div>
</template>

<script>

  import VueFormGenerator from 'vue-form-generator/dist/vfg.js'
  import 'vue-form-generator/dist/vfg.css'
  import cleave from 'cleave.js'

  require('cleave.js/dist/addons/cleave-phone.us');
  require('cleave.js/dist/addons/cleave-phone.ca');

  let optionsIn = {
    validateAfterLoad: false,
    validateAfterChanged: true,
    fieldIdPrefix: 'attendee_'//+ id
  };
  export default {
    name: "AcupunctureLicense",
    components: {
      "vue-form-generator": VueFormGenerator.component,
    },
    props:['model-id'],
    data() {
      return {
        acupuncturist: null,
        formOptions: optionsIn,
        model: {
          licenseNumber: '',
          licenseCountry: '',
          licenseState: '',
        },
        schema: {
          groups: [
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
                  },
                  placeholder: 'Select a state/province',
                  styleClasses: ['col-md-8']
                },
                {
                  type: 'input',
                  inputType: 'text',
                  label: 'License Number',
                  model: 'licenseNumber',
                  placeholder: '213BA',
                  styleClasses: ['col-md-4']
                },
                {
                  type: 'select',
                  label: 'Country',
                  model: 'licenseCountry',
                  values: countries,
                  selectOptions: {
                    noneSelectedText: "Select a country"
                  },
                  styleClasses: ['col-md-8']
                },

              ]
            }

          ]
        }
      }
    }
  }
</script>

<style scoped>

</style>