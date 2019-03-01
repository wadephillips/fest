<template>
  <div>
    <h2>
      <slot name="heading">Successfully Registered Attendees</slot>
    </h2>
    <table class="table">
      <thead>
      <tr>
        <th>Name</th>
        <th>Registration Options</th>
        <th>Amount</th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="attendee in this.attendees">
        <td scope="row">{{ attendee.name }}</td>
        <td>
          <ul>
            <li v-for="k in getDetails(attendee.modifiers)">{{ k.description }}</li>
          </ul>
        </td>
        <td>${{ attendee.total/100 }}.00</td>
      </tr>
      <tr>
        <td></td>
        <td class="text-right"><strong>Total:</strong></td>
        <td><strong>${{ total / 100 }}.00</strong></td>
      </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
  export default {
    name: "AttendeeTable",
    props: ['attendees', 'total'],
    methods: {
      getDetails(mods) {
        return _.merge(mods.payment, mods.meal);
      },
    },
  }
</script>

<style scoped>

</style>