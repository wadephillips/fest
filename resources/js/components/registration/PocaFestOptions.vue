<template>

  <vue-form-generator
      :model="model"
      :options="formOptions"
      :schema="schema"
      @validated="formUpdated"
      class=""
      tag="div"
      ref="optform"
  >
  </vue-form-generator>

</template>

<script>

  import VueFormGenerator from 'vue-form-generator/dist/vfg.js'
  import 'vue-form-generator/dist/vfg.css'
  import rangeSlider from 'ion-rangeslider/js/ion.rangeSlider'
  import 'ion-rangeslider/css/ion.rangeSlider.css'
  import { get as objGet, isFunction} from "lodash";


  export default {
    name: "PocaFestOptions",
    components: {
      "vue-form-generator": VueFormGenerator.component,
      rangeSlider
    },
    props: ['model-id'],
    data() {
      return {
        id: null,
        total: 0,
        formOptions: {
          validateAfterLoad: false,
          validateAfterChanged: true,
          fieldIdPrefix: 'attendee_'//+ id
        },
        model: {
          registration_type: '',
          prices: {
            three_day_overnight_pass: 300,
            three_day_day_only: 250,
            ear_training_overnight: 300,
            ear_training_day_only: 250,
            student: 150,
            fso_adult: 100,
            fso_child: 100,
            one_day_pass: 125,
            one_day_add_ceu: 75,
          },
          chosen: {},
          meal: {
            type: ''
          }
        },
        schema: {
          groups: [
            {
              legend: 'Registration options for this attendee',
              class: 'col-md-6',
              fields: [
                {
                  type: "radios",
                  label: "How are you attending POCA Fest?",
                  model: "registration_type",
                  required: true,
                  values: [
                    {name: "Three Day Pass - Overnight Stay", value: "three_day_overnight_pass"},
                    {name: "Three Day Pass - No Overnight Stay", value: "three_day_day_only"},
                    {name: "Ear Training - 3 Day Pass - Overnight Stay", value: "ear_training_overnight"},
                    {name: "Ear Training - 3 Day Pass - No Overnight Stay", value: "ear_training_day_only"},
                    {name: "Student - 3 Day Pass", value: "student"},
                    {name: "Additional Family Member / Significant Other - Adult", value: 'fso_adult'},
                    {name: "Additional Family Member / Significant Other - Child", value: 'fso_child'},
                    {name: "One Day Only Pass", value: "one_day_pass"}
                  ],
                validator: ['string'],
                  set: function (model, value) {

                    let wildcardSelector = 'attendee_' + model.id + '_rs';
                    let selector = 'attendee_' + model.id + '_rs_' + value;


                    $('label[for^="' + wildcardSelector + '"]').each(function () {
                      $(this).parent().hide()
                    });

                    $('label[for="' + selector + '"]').parent().show();
                    let price = 0;
                    let keys = Object.keys(model.chosen);

                    let key = value;

                    if (keys.length === 0) {
                      price = model.prices[key] * 100
                    } else if (['fso_adult', 'fso_child', 'add_ceu_one_day_pass'].indexOf(keys[0])) {
                      price = model.prices[key] * 100;
                    } else {
                      let oldKey = keys[0];
                      price = model.chosen[oldKey];
                    }
                    model.chosen = {};

                    model.registration_type = key;
                    model.chosen[key] = price
                  }
                },
                {
                  type: "rangeSlider",
                  label: "Sliding Scale, set your price - Three Day Pass - Overnight Stay - $250 - $500",
                  model: 'prices.three_day_overnight_pass',
                  id: 'rs_three_day_overnight_pass',
                  min: 250,
                  max: 500,
                  rangeSliderOptions: {
                    force_edges: true
                  },

                  set: function (model, value) {
                    console.log(value);
                    model.chosen.three_day_overnight_pass = value * 100
                  }
                },
                {
                  type: "rangeSlider",
                  label: "Sliding Scale, set your price - Three Day Pass - No Overnight Stay - $250 - $500",
                  model: 'prices.three_day_day_only',
                  id: 'rs_three_day_day_only',
                  min: 200,
                  max: 500,


                  set: function (model, value) {
                    model.chosen.three_day_day_only = value * 100
                  }
                },
                {
                  type: "rangeSlider",
                  label: "Sliding Scale, set your price - Ear Training - 3 Day Pass - Overnight Stay - $250 - $500",
                  model: 'prices.ear_training_overnight',
                  id: 'rs_ear_training_overnight',
                  min: 250,
                  max: 500,


                  set: function (model, value) {
                    model.chosen.ear_training_overnight = value * 100
                  }
                },
                {
                  type: "rangeSlider",
                  label: "Sliding Scale, set your price - Ear Training - 3 Day Pass - No Overnight Stay - $200 - $500",
                  model: 'prices.ear_training_day_only',
                  id: 'rs_ear_training_day_only',
                  min: 200,
                  max: 500,
                  set: function (model, value) {
                    model.chosen.ear_training_day_only = value * 100
                  }
                },
                {
                  type: "rangeSlider",
                  label: "Sliding Scale, set your price - Student - 3 Day Pass - $100 - $200",
                  model: 'prices.student',
                  id: 'rs_student',
                  min: 100,
                  max: 200,
                  set: function (model, value) {
                    model.chosen.student = value * 100
                  }
                },
                {
                  type: "rangeSlider",
                  label: "Sliding Scale, set your price - One Day Pass- $100 - $200",
                  model: 'prices.one_day_pass',
                  id: 'rs_one_day_pass',
                  min: 100,
                  max: 200,
                  set: function (model, value) {
                    model.chosen.one_day_pass = value * 100
                  }
                },
                {
                  type: 'checkbox',
                  label: 'I need to add CEUs to my one day pass.',
                  model: 0,
                  id: 'one_day_add_ceu',
                  set: function (model, value) {
                    model.chosen.one_day_add_ceu = value * model.prices.one_day_add_ceu * 100
                  },
                  visible: function (model) {
                    return this.model && this.model.registration_type === "one_day_pass";
                  },
                }
              ]
            },
            {
              legend: "Other options",
              fields: [
                {
                  type: "radios",
                  label: "Food Preference",
                  model: "meal.type",
                  id: 'meal_type',
                  dusk: 'meal_type',
                  required: true,
                  validator: ['string'],
                  values: [
                    "Omnivore",
                    "Vegetarian",
                    "Vegan"
                  ],
                },
                {
                  type: "input",
                  inputType: "text",
                  label: "Other Dietary Restrictions",
                  model: "meal.other_food",
                  id: 'other_food',
                  hint: "At this time we are unable to guarantee that our hosts can accommodate any special food needs.  We will inquire and communicate back with you.",
                  validator: 'string'
                },
                // {
                //   type:"submit",
                //   styleClasses: "btn btn-success",
                //   onSubmit:'submitForm',
                //   validateBeforeSubmit: true
                // }
              ],
            },
          ]
        },
      }
    },
    computed: {
      optionsTotal() {

        return this.calculateTotal();
      }
    },
    created() {
      let self = this;
      this.model.id = this.modelId;
      this.formOptions.fieldIdPrefix += this.modelId + '_';

      //could this be extracted into a mixin or something?
      Bus.$on('validateForms', function ($event) {
        $event.preventDefault();
        let validateAsync = (objGet(self.$refs.optform.$data.vfg.options, "validateAsync", false));

        let errors = self.$refs.optform.vfg.validate();

        let handleErrors = errors => {
          if ((validateAsync && !isEmpty(errors)) || (!validateAsync && !errors)) {
            if (isFunction(self.schema.onValidationError)) {

              self.schema.onValidationError(self.model, self.schema, errors, $event);
            }
          } else if (!validateAsync && errors) {

            Bus.$emit('subFormValidated', {pocaFestOptions: true});

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

        this.total = this.calculateTotal();
        let payload = {
          id: this.modelId,
          modifiers: {
            payment: this.model.chosen,
            meal: this.model.meal
          } ,
          amount: this.total
        };
        Bus.$emit('updateAttendeeModel', payload);
      },
      calculateTotal() {
        let total = 0
        for (let i in this.model.chosen) {
          total += this.model.chosen[i];
        }
        return total
      },
      submitForm(model, schema, $event) {
        $event.preventDefault();
        console.log(model);
      }
    },
    mounted() {
      let wildcardSelector = 'attendee_' + this.model.id + '_rs';

      $('label[for^="' + wildcardSelector + '"]').each(function () {
        $(this).parent().hide()
      });
    }
  }
</script>

<style scoped>

</style>