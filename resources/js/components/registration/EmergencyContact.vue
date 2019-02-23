<template>
  <div>
    <vue-form-generator @validated="formUpdated" :model="model" :options="formOptions" :schema="schema">
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
  export default {
    name: "EmergencyContact",
    components: {
      "vue-form-generator": VueFormGenerator.component,
    },
    props:['model-id'],
    data() {
      return {
        formOptions: {
          validateAfterLoad: false,
          validateAfterChanged: true,
          fieldIdPrefix: 'attendee_'//+ id
        },
        model: {
          id: null,
          emergency_contact_name: '',
          emergency_contact_relationship: '',
          emergency_contact_phone: ''
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
                  model: 'emergency_contact_name',
                  placeholder: 'Bill Murray',
                  featured: true,
                  required: true,
                  id: 'emergency_contact_name'
                },
                {
                  type: 'cleave',
                  label: 'Emergency Contact Phone',
                  model: 'emergency_contact_phone',
                  cleaveOptions: {
                    phone: true,
                    phoneRegionCode: 'US'
                  },
                  required: true,
                  placeholder: '555-555-5555',
                  id: 'emergency_contact_phone'
                },
                {
                  type: 'input',
                  inputType: 'text',
                  label: 'Relationship to Emergency Contact ',
                  model: 'emergency_contact_relationship',
                  required: true,
                  placeholder: 'Father',
                  id: 'emergency_contact_relationship'
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