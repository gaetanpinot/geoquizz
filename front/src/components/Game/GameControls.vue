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
  position: relative;
}
.controles button {
  margin: 0 10px;
  padding: 8px 16px;
  font-size: 1em;
  background: none;
  color: white;
  border: 0;
  border-radius: 20px;
  border: 2px solid darkorange;
  color: orange;
  margin-top: 12px;
}

.controles button:hover {
  background: darkorange;
  transition: 0.3s;
  color: black;
}
</style>
