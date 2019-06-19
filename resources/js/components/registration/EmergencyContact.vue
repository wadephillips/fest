<template>
  <div>
    <vue-form-generator
        :model="model"
        :options="formOptions"
        :schema="schema"
        @validated="formUpdated"
        ref="emergencyContactForm"
    >
    </vue-form-generator>
  </div>
</template>

<script>

  import VueFormGenerator from 'vue-form-generator/dist/vfg.js'
  // import 'vue-form-generator/dist/vfg.css'
  import cleave from 'cleave.js'
  import { get as objGet, isFunction} from "lodash";


  require('cleave.js/dist/addons/cleave-phone.us');
  require('cleave.js/dist/addons/cleave-phone.ca');

  export default {
    name: "EmergencyContact",
    components: {
      "vue-form-generator": VueFormGenerator.component,
    },
    props: ['model-id'],
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
                  // featured: true,
                  required: true,
                  id: 'emergency_contact_name',
                  validator: ['string']
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
                  id: 'emergency_contact_phone',
                  validator: ['string']
                },
                {
                  type: 'input',
                  inputType: 'text',
                  label: 'Relationship to Emergency Contact ',
                  model: 'emergency_contact_relationship',
                  required: true,
                  placeholder: 'Father',
                  id: 'emergency_contact_relationship',
                  validator: ['string']
                },
              ]
            }
          ]
        }
      }
    },
    created() {
      let self = this;

      this.model.id = this.modelId;
      this.formOptions.fieldIdPrefix += this.modelId + '_';

      Bus.$on('validateForms', function ($event) {
        $event.preventDefault();
        let validateAsync = (objGet(self.$refs.emergencyContactForm.$data.vfg.options, "validateAsync", false));

        let errors = self.$refs.emergencyContactForm.vfg.validate();

        let handleErrors = errors => {
          if ((validateAsync && !isEmpty(errors)) || (!validateAsync && !errors)) {
            if (isFunction(self.schema.onValidationError)) {

              self.schema.onValidationError(self.model, self.schema, errors, $event);
            }
          } else if (!validateAsync && errors) {

            Bus.$emit('subFormValidated', {emergencyContact: true});

          }

        };
        if (errors && isFunction(errors.then)) {
          errors.then(handleErrors);
        } else {
          handleErrors(errors);
        }
      });

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