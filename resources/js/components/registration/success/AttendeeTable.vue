<template>
  <div>
    <h2>
      <slot name="heading">Successfully Registered Attendees</slot>
    </h2>
    <table class="table">
      <thead>
      <tr>
        <th>Name</th>
        <th>Registration</th>
        <th>Amount</th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="attendee in this.attendees">
        <td scope="row">{{ attendee.name }}</td>
        <td>
          <ul>
            <li v-for="k in this.getDetails(attendee.modifiers)">{{k}}</li>
          </ul>
        </td>

      </tr>
      <tr>
        <td></td>
        <td class="text-right"><strong>Total:</strong></td>
        <td><strong>{{this.total}}</strong></td>
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
      getDetails(mods){
        let flat = _.merge(mods.purchased, mods.meal);
        return Object.keys(flat);
      },
    }

  }
</script>

<style scoped>

</style>