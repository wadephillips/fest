<template>
  <section>
    <div class="row">

      <div class="col-md-6">
        <attendee-details :dusk="'attendee-details-' + this.model.id" :key="this.model.id" :model-id="this.model.id"></attendee-details>
      </div>
      <div class="col-md-6">
        <div class="col-md-12">
          <emergency-contact :dusk="'emergency-contact-' + this.model.id" :key="this.model.id" :model-id="this.model.id"></emergency-contact>
        </div>

        <div class="col-md-12">
          <acupuncture-license :dusk="'acupuncture-license-' + this.model.id" :key="this.model.id" :model-id="this.model.id"></acupuncture-license>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-3">
        <h4 :dusk="'attendee-total-' + this.model.id"  >Attendee Total: ${{(this.model.amount / 100).toFixed(2)}}</h4>
      </div>

      <div class="col-md-9">
        <poca-fest-options :dusk="'poca-fest-options-' + this.model.id" :key="this.model.id" :model-id="this.model.id" :presenter="this.presenter"></poca-fest-options>
      </div>
      
    </div>
  </section>
</template>

<script>
  import AttendeeDetails from "./AttendeeDetails";
  import EmergencyContact from "./EmergencyContact";
  import AcupunctureLicense from "./AcupunctureLicense";
  import PocaFestOptions from "./PocaFestOptions";
  export default {
    name: "Attendee",
    components: {AcupunctureLicense,
      EmergencyContact,
      AttendeeDetails,
      PocaFestOptions},
    props: ['model', 'presenter'],
    data() {
      return {
      }
    }
  }
</script>

<style scoped>

</style>