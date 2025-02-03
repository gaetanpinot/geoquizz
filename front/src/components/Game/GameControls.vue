<template>
  <div class="controles">
    <button v-if="marqueurEstimation && !confirme" @click="$emit('confirmer')">Confirmer</button>
    <button v-if="confirme && manche < totalManches" @click="$emit('suivant')">Manche suivante</button>
    <button v-if="confirme && manche === totalManches" @click="$emit('terminer')">Terminer le jeu</button>
  </div>
</template>

<script>
export default {
  name: 'GameControls',
  props: ['marqueurEstimation', 'confirme', 'manche', 'totalManches']
}
</script>

<style scoped>
.controles {
  text-align: center;
  margin-bottom: 20px;
}
.controles button {
  margin: 0 10px;
  padding: 8px 16px;
  font-size: 1em;
}
</style>
