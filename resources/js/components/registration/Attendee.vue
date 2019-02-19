<template>
  <section>
    <div class="row">
      <div class="col-3-md">
        <attendee-details></attendee-details>
      </div>
      <div class="col-3-md">
        <emergency-contact></emergency-contact>
      </div>
      <div class="col-3-md">
        <acupuncture-license></acupuncture-license>
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
    components: {AcupunctureLicense, EmergencyContact, AttendeeDetails}
  }
</script>

<style scoped>

</style>