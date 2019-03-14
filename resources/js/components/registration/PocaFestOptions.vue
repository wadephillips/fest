<template>

  <vue-form-generator
      :model="model"
      :options="formOptions"
      :schema="schema"
      @model-updated="formUpdated"
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
    props: ['model-id', 'presenter'],
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
          donate: 0,
          prices: {
            presenter: 150,
            three_day_overnight_pass: 300,
            three_day_day_only: 250,
            ear_training_overnight: 300,
            ear_training_day_only: 250,
            student: 150,
            fso_adult: 100,
            fso_child: 100,
            one_day_pass: 125,
            one_day_add_ceu: 75,
            poca_tech_donation: 5,
            linens: 15,
          },
          chosen: {},
          meal: {},
          food: {},
          options: {},
          other: "",
          linens: "No"
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
                  id: 'registration_type',
                  attributes: {
                    "name" :  'attendee_' + this.modelId + '_registration_type'
                  },
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

                    // console.log($(selector).closest('.is-checked').val());


                    $('label[for^="' + wildcardSelector + '"]').each(function () {
                      $(this).parent().hide()
                    });

                    $('label[for="' + selector + '"]').parent().show();
                    let price = 0;
                    let keys = Object.keys(model.chosen);

                    let key = value;
                    // let oldKey = keys[0];
                    let oldKey = model.registration_type;

                    price = model.prices[key] * 100



                    if (model.chosen.hasOwnProperty(oldKey) && model.chosen.hasOwnProperty('one_day_add_ceu')) {
                      delete model.chosen.one_day_add_ceu
                    }

                    if (model.chosen.hasOwnProperty(oldKey)) {
                      console.log('deleting it');
                      delete model.chosen[oldKey]
                    }

                    model.registration_type = key;

                    let  description = $('input[value="' + value +'"]').closest('label')[0].innerText;

                    // model.chosen[key] = price;
                    model.chosen[key] = { description :description, value: price};

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
                    model.chosen.three_day_overnight_pass.value = value * 100
                  }
                },
                {
                  type: "rangeSlider",
                  label: "Sliding Scale, set your price - Presenter Three Day Pass - $100 - $300",
                  model: 'prices.presenter',
                  id: 'rs_presenter',
                  attributes: {
                    "name" :  'attendee_' + this.modelId + '_rs_presenter',
                    'dusk' : 'presenter-rs-' + this.modelId
                  },
                  min: 100,
                  max: 300,
                  rangeSliderOptions: {
                    force_edges: true,
                    prefix: '$',
                  },
                  set: function (model, value) {
                    model.chosen.presenter.value = value * 100
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
                    model.chosen.three_day_day_only.value = value * 100
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
                    model.chosen.ear_training_overnight.value = value * 100
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
                    model.chosen.ear_training_day_only.value = value * 100
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
                    model.chosen.student.value = value * 100
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
                    model.chosen.one_day_pass.value = value * 100
                  }
                },
                {
                  type: 'checkbox',
                  label: 'I need to add CEUs to my one day pass.',
                  model: 0,
                  id: 'one_day_add_ceu',
                  set: function (model, value) {
                    model.chosen.one_day_add_ceu = {
                      value: value * model.prices.one_day_add_ceu * 100,
                      description: 'Add CEUs to my one day pass.'
                    }
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
                  model: "food.type",
                  id: 'meal_type',
                  attributes: {
                    "name" :  'attendee_' + this.modelId + '_meal_type'
                    //todo resume
                  },
                  dusk: 'meal_type',
                  required: true,
                  validator: ['string'],
                  values: [
                    "Omnivore",
                    "Vegetarian",
                    "Vegan"
                  ],
                  set: function (model, value) {
                    model.food.type = value;
                    model.meal['type'] = {
                      description: value,

                    };
                  }
                },
                {
                  type: "input",
                  inputType: "text",
                  label: "Other Dietary Restrictions",
                  model: "food.other_food",
                  id: 'other_food',
                  hint: "At this time we are unable to guarantee that our hosts can accommodate any special food needs.  We will inquire and communicate back with you.",
                  validator: 'string',
                  set: function (model, value) {
                    model.meal['other_food'] = {
                      description: value,
                    };
                  }
                },
                {
                  type: "radios",
                  label: "Do you need linens?",
                  hint: "The Perlman Retreat Center will provide you with linens for $15 if you select Yes.",
                  model: "linens",
                  // inputName: 'attendee_' + this.modelId + '_linens',
                  attributes: {
                      "name" :  'attendee_' + this.modelId + '_linens'
                  },
                  id: 'linens',
                  dusk: 'linens',
                  required: true,
                  validator: ['string'],
                  values: [
                    "Yes",
                    "No"
                  ],
                  set: function (model, value) {
                    model.linens = value;
                    let price = (value === 'Yes') ? model.prices.linens * 100 : 0;
                    let description = "Linens: " + value;
                    model.options.linens = {
                      value: price,
                      description: description
                    };
                  }
                },
                {
                  type: "textArea",
                  label: "Other Attendee Information:",
                  id: "other_info",
                  model: "other",
                  hint: "Use this space to tell us anything else that would make your POCA Fest the best!",
                  rows: 4,
                  validator: ['string']
                },
                {
                  type: 'checkbox',
                  label: "I'd like to support affordable Acupuncture Education by donating $5 to POCA Tech!",
                  model: 'donate',
                  id: 'poca_tech_donation',
                  set: function (model, value) {

                    model.chosen.poca_tech_donation = {
                      value: value * model.prices.poca_tech_donation * 100,
                      description: 'Donate $5 to POCA Tech'
                    };
                    if (value === false) {
                      delete model.chosen.poca_tech_donation;
                    }
                  },
                }

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

        //calculate the current total for the attendee
        this.total = this.calculateTotal();

        // copy and assign chosen attendance options to payment
        let payment = Object.assign({}, this.model.chosen);
        // add linens to payment object
        payment.linens = this.model.options.linens;

        //build the payload
        let payload = {
          id: this.modelId,
          modifiers: {
            payment: payment,
            meal: this.model.meal,
           // linens: this.model.options.linens, //move this into the payment object
          } ,
          amount: this.total
        };

        if (this.model.other !== "") {
          let obj = {other: {value: this.model.other,  description: this.model.other}};
          payload.modifiers['other'] = obj;
        }
        Bus.$emit('updateAttendeeModel', payload);
      },
      calculateTotal() {
        let total = 0;
        for (let i in this.model.chosen) {
          total += this.model.chosen[i].value;
        }
        for (let i in this.model.options) {
          total += this.model.options[i].value;
        }

        return total
      },
      // submitForm(model, schema, $event) {
      //   $event.preventDefault();
      //   console.log(model);
      // }
    },
    mounted() {
      let wildcardSelector = 'attendee_' + this.model.id + '_rs';

      $('label[for^="' + wildcardSelector + '"]').each(function () {
        $(this).parent().hide()
      });

      //if this is a presenter registration lets add an option to the registration type
      if (this.presenter) {
        this.schema.groups[0].fields[0].values.unshift({name:"Presenter Three Day Pass", value:"presenter"})
      }
    }
  }
</script>

<style scoped>

</style>