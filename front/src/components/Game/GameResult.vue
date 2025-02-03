<template>
  <div class="resultat" v-if="distance !== null">
    <p>Votre estimation est à {{ distance.toFixed(2) }} mètres de la cible.</p>
    <p>Points pour cette manche : {{ pointsManche }}</p>
  </div>
</template>

<script>
export default {
  name: 'GameResult',
  props: ['distance', 'pointsManche']
}
</script>

<style scoped>
.resultat {
  text-align: center;
  margin-bottom: 20px;
}
</style>
