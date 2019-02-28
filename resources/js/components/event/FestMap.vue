<template>
  <map name="fest-map" id="fest-map">
    <iframe width="100%" height="400px" frameborder="0" style="border:0"
            :src="this.getEmbedUrl" allowfullscreen></iframe>
  </map>
</template>

<script>
  export default {
    name: "FestMap",
    props:['place-id', 'api-key'],
    computed: {
      getEmbedUrl() {
        let url = 'https://www.google.com/maps/embed/v1/place?q=place_id:';
        url += this.placeId;
        url += '&key=';
        url += this.apiKey;

        return url;
      }
    }
  }
</script>

<style scoped>

</style>