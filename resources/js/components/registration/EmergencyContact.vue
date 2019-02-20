<template>
  <div>
    <vue-form-generator :model="model" :options="formOptions" :schema="schema">
    </vue-form-generator>
  </div>
</template>

<script>

  import VueFormGenerator from 'vue-form-generator/dist/vfg.js'
  import 'vue-form-generator/dist/vfg.css'
  import cleave from 'cleave.js'

  require('cleave.js/dist/addons/cleave-phone.us');
  require('cleave.js/dist/addons/cleave-phone.ca');

  //todo: this isn't working try adding formOptions or id to computed
  let optionsIn = {
    validateAfterLoad: false,
    validateAfterChanged: true,
    fieldIdPrefix: 'attendee_'//+ id
  };
  export default {
    name: "EmergencyContact",
    components: {
      "vue-form-generator": VueFormGenerator.component,
    },
    props:['model-id'],
    data() {
      return {
        formOptions: optionsIn,
        model: {
          emergencyContactName: '',
          emergencyContactRelationship: '',
          emergencyContactPhone: ''
        },
        schema: {
          groups: [
            {
              legend: 'Emergency Contact Info',
              fields: [
                {
                  type: 'input',
                  inputType: 'text',
                  label: 'Emergency Contact Name',
                  model: 'emergencyContactName',
                  placeholder: 'Bill Murray',
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
                  placeholder: '555-555-5555'
                },
                {
                  type: 'input',
                  inputType: 'text',
                  label: 'Relationship to Emergency Contact ',
                  model: 'emergencyContactRelationship',
                  required: true,
                  placeholder: 'Father'
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