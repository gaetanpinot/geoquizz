<template>
    <section>
      <header>
        <div class="info-cible">
          <h2>Manche {{ manche }} / {{ totalManches }}</h2>
          <p>Score global : {{ scoreGlobal }}</p>
          <h3>Déterminez l'emplacement de l'image à droite :</h3>
          <GameControls
            :marqueurEstimation="marqueurEstimation"
            :confirme="confirme"
            :manche="manche"
            :totalManches="totalManches"
            @confirmer="confirmerEstimation"
            @suivant="mancheSuivante"
            @terminer="terminerJeu"
          />
          <div class="timer-bg">
            <div class="timer" :style="{ width: (time / maxTime) * 100  + '%'}"></div>
          </div>
          <GameResult v-if="confirme && distance !== null" :distance="distance" :pointsManche="pointsManche" />
        </div>
        <GameMap
          :coordCible="coordCible"
          :confirme="confirme"
          @marqueur-place="mettreAJourEstimation"
          ref="gameMap"
        />
      </header>

      <div class="game" :style="{ backgroundImage: 'url( ' + currentImageUrl + ' )'}">

      </div>
    </section>
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
        scoreGlobal: 0,
        maxTime: 30,
        time: 30,
        timeInterval: null,
        currentImageUrl: "https://upload.wikimedia.org/wikipedia/commons/3/3c/Vue_de_nuit_de_la_Place_Stanislas_%C3%A0_Nancy.jpg"
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
        } catch {
          this.coordCible.lon = 20;
          this.coordCible.lat = 20;
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
      this.recupererDonneesCible();
      this.timeInterval = setInterval(() => {
        this.time--;
        if(this.time <= 0)
          clearInterval(this.timeInterval);
      }, 1000);
    }
  }
  </script>

  <style scoped>

  header {
    background: #181818;
    width: 30%;
    height: calc(100vh - 70px);
    display: flex;
    justify-content: space-between;
    flex-direction: column;
    border-right: 3px solid #181818;
  }

  section {
    display: flex;
  }

  .game {
    width: 70%;
    background-size: cover;
    background-position: center;
  }

  .info-cible {
    color: white;
    background: #242424;
    padding: 20px;
    text-align: center;
    position: relative;
  }

  .timer-bg {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 12px;
    background: black;
  }

  .timer {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 66%;
    top: 0;
    background: darkorange;
    transition: width 1s;
  }

  </style>
