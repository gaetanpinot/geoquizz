<template>
  <div class="resultat" v-if="distance !== null">
    <p>Votre estimation est à {{ realDistance }} de la cible.</p>
    <p>Points pour cette manche : {{ pointsManche }}</p>
  </div>
</template>

<script>
export default {
  name: 'GameResult',
  props: ['distance', 'pointsManche'],

  computed: {
    realDistance() {
      if(this.distance < 1000)
        return this.distance.toFixed(2) + "m";

      return (this.distance / 1000).toFixed(2) + "km";
    }
  }
}
</script>

<style scoped>
.resultat {
  text-align: center;
  margin-bottom: 20px;
}
</style>
