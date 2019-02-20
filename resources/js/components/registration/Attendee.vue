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
  </section>
</template>

<script>
  import AttendeeDetails from "./AttendeeDetails";
  import EmergencyContact from "./EmergencyContact";
  import AcupunctureLicense from "./AcupunctureLicense";
  export default {
    name: "Attendee",
    components: {AcupunctureLicense, EmergencyContact, AttendeeDetails},
    props: ['model'],
    data() {
      return {
      }
    }
  }
</script>

<style scoped>

</style>