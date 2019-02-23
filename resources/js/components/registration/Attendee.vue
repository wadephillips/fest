<template>
  <section>
    <div class="row">

      <div class="col-md-6">
        <attendee-details :key="this.model.id" :model-id="this.model.id"></attendee-details>
      </div>
      <div class="col-md-6">
        <div class="col-md-12">
          <emergency-contact :key="this.model.id" :model-id="this.model.id"></emergency-contact>
        </div>

        <div class="col-md-12">
          <acupuncture-license :key="this.model.id" :model-id="this.model.id"></acupuncture-license>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-3 ml-0">
        <h4 >Attendee Total: ${{this.model.amount / 100}}</h4>
      </div>
        <poca-fest-options dusk="poca-fest-options" :key="this.model.id" :model-id="this.model.id"></poca-fest-options>
      
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
    props: ['model'],
    data() {
      return {
      }
    }
  }
</script>

<style scoped>

</style>