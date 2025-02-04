<template>
    <div class="jeu">
      <h2>Manche {{ manche }} / {{ totalManches }}</h2>
      <p>Score global : {{ scoreGlobal }}</p>

      <div class="info-cible">
        <h3>Déterminez l'emplacement en vous basant sur l'image :</h3>
        <img :src="imageCible" alt="Image de la cible" v-if="imageCible" />
      </div>


      <div>
        <GameMap
          :coordCible="coordCible"
          :confirme="confirme"
          @marqueur-place="mettreAJourEstimation"
          ref="gameMap"
        />
      </div>


      <div>
        <GameControls
          :marqueurEstimation="marqueurEstimation"
          :confirme="confirme"
          :manche="manche"
          :totalManches="totalManches"
          @confirmer="confirmerEstimation"
          @suivant="mancheSuivante"
          @terminer="terminerJeu"
        />
      </div>

      <GameResult v-if="confirme && distance !== null" :distance="distance" :pointsManche="pointsManche" />
    </div>
  </template>

  <script>
import GameMap from '@/components/Game/GameMap.vue';
import GameControls from '@/components/Game/GameControls.vue';
import GameResult from '@/components/Game/GameResult.vue';

  export default {
    name: 'Game',
    components: { GameMap, GameControls, GameResult },
    data() {
      return {
        manche: 1,
        totalManches: 10,
        imageCible: '',
        coordCible: null,

        marqueurEstimation: null,
        confirme: false,
        distance: null,
        pointsManche: 0,
        scoreGlobal: 0
      }
    },
    methods: {
      async recupererDonneesCible() {
        try {
          const reponse = await fetch('https://example.com/api/target')
          if (!reponse.ok) throw new Error("Erreur de récupération")
          const donnees = await reponse.json()
          this.imageCible = donnees.imageUrl
          this.coordCible = donnees.targetCoords
        } catch (erreur) {

          this.coordCible = { lat: 48.692054, lon: 6.184417 }
          this.imageCible = "https://via.placeholder.com/300x200?text=Image+Cible+Nancy"
        }
      },
      mettreAJourEstimation(coord) {

        this.marqueurEstimation = coord
      },
      confirmerEstimation() {
        if (!this.marqueurEstimation) return
        this.confirme = true

        this.$refs.gameMap.afficherResultats(this.coordCible, this.marqueurEstimation)

        this.distance = this.$refs.gameMap.calculerDistance(this.coordCible, this.marqueurEstimation)


        const maxPoints = 1000
        const maxDistance = 1000000
        const ratio = Math.min(this.distance / maxDistance, 1)
        this.pointsManche = Math.round(maxPoints * (1 - ratio))
      },
      mancheSuivante() {
        this.scoreGlobal += this.pointsManche
        if (this.manche < this.totalManches) {
          this.manche++
          this.confirme = false
          this.recupererDonneesCible()
          this.$refs.gameMap.reinitialiserCarte()
        }
      },
      terminerJeu() {
        this.scoreGlobal += this.pointsManche
      }
    },
    mounted() {
      this.recupererDonneesCible()
    }
  }
  </script>

  <style scoped>
  .jeu {
    text-align: center;
  }

  </style>
