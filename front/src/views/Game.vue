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
            :disabled="marqueurEstimation == null"
            @confirmer="confirmerEstimation"
            @suivant="mancheSuivante"
            @terminer="terminerJeu"
          />
          <div v-if="!freeze" class="timer-bg">
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
import {GATEWAY_API} from "@/config.js";
  export default {
    name: 'Game',
    components: {GameMap, GameControls, GameResult},
    data() {
      return {
        ID_PARTIE: -1,
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
        freeze: false,
        currentImageUrl: ""
      }
    },
    methods: {
      async recupererDonneesCible() {
        try {
          this.$api.get("/parties/" + ID_PARTIE + "/next")
          if (!reponse.ok)
            throw new Error("Erreur de récupération")
          const donnees = await reponse.json()
          this.currentImageUrl = `${GATEWAY_API}/assets/${donnees.urlImage}`;
          this.coordCible = {
            lat: donnees.lat,
            lon: donnees.lon
          }
        } catch {
          this.coordCible = {lat: 48.692054, lon: 6.184417}
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
        this.freeze = true;
      },
      mancheSuivante() {
        this.scoreGlobal += this.pointsManche
        if (this.manche < this.totalManches) {
          this.manche++
          this.confirme = false
          this.recupererDonneesCible()
          this.$refs.gameMap.reinitialiserCarte()
          this.time = this.maxTime;
          this.freeze = false;
          this.marqueurEstimation = null;
        }
      },
      terminerJeu() {
        this.scoreGlobal += this.pointsManche
      }
    },
    mounted() {
      this.$api.post("/parties").then(res => {
        console.log(res);
        if(res.status == 201) {
          this.ID_PARTIE = res.data.data.id;
          this.recupererDonneesCible();
        }
      })
      this.timeInterval = setInterval(() => {
        if(!this.freeze) {
          this.time--;
        }
        if (this.time <= 0)
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
    background-color: #242424;
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
  }

  </style>
