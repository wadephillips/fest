<template>
  <section>
    <div class="row">

      <div class="col-md-6">
        <attendee-details></attendee-details>
      </div>
      <div class="col-md-6">
        <div class="col-md-12">
          <emergency-contact></emergency-contact>
        </div>

        <div class="col-md-12">
          <acupuncture-license></acupuncture-license>
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
    data() {
      return {
      }
    }
  }
</script>

<style scoped>

</style>