<template>
  <div>
    <div class="form-group" >
      <span class="switch switch-sm">
        <input :key="modelId" v-model="acupuncturist"  type="checkbox" class="switch" :id="modelId + '-acu-switch'">
        <label :for="modelId + '-acu-switch'">Acupuncturist</label>
      </span>
    </div>
    <vue-form-generator :key="modelId" @validated="formUpdated" v-show="acupuncturist" :model="model" :options="formOptions" :schema="schema">
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
    fieldIdPrefix: 'attendee_'// model-id added in created()
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
          id: null,
          license_number: '',
          license_country: '',
          license_state: '',
        },
        schema: {
          groups: [
            {
              legend: 'Acupuncture License Info',
              fields: [
                {
                  type: "select",
                  label: "State or Province",
                  model: "license_state",
                  // required: true,
                  values: states,
                  // default: "en-US",
                  // validator: validators.required
                  selectOptions: {
                    noneSelectedText: "Select a state/province"
                  },
                  placeholder: 'Select a state/province',
                  styleClasses: ['col-md-8'],
                  id: 'license_state'
                },
                {
                  type: 'input',
                  inputType: 'text',
                  label: 'License Number',
                  model: 'license_number',
                  placeholder: '213BA',
                  styleClasses: ['col-md-4'],
                  id: 'license_number'
                },
                {
                  type: 'select',
                  label: 'Country',
                  model: 'license_country',
                  values: countries,
                  selectOptions: {
                    noneSelectedText: "Select a country"
                  },
                  styleClasses: ['col-md-8'],
                  id: 'license_country'
                },

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