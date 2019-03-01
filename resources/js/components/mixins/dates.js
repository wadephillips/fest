import moment from 'moment';

export const dates = {
  computed: {
    eventDates(format = "dddd, MMMM Do, YYYY") {

      let eventDatesStr = "";
      let start = moment(this.event.start);
      let end = moment(this.event.end);
      if (end.diff(start, "days") >= 1) {
        eventDatesStr = start.format("dddd, MMMM Do, YYYY") + "  >>  " + end.format("dddd, MMMM Do, YYYY");
      } else {
        eventDatesStr = start.format("dddd MMM Do, YYYY");
      }
      return eventDatesStr;
    }
  }
}