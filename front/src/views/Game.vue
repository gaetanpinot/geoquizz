<template>
  <section v-if="!partieFini">
    <header>
      <div class="info-cible">
        <h2>Manche {{ manche }} / {{ totalManches }}</h2>
        <p>Score global : {{ scoreGlobal }}</p>
        <h3>Déterminez l'emplacement de l'image à droite :</h3>
        <GameControls :marqueurEstimation="marqueurEstimation" :confirme="confirme" :manche="manche"
          :totalManches="totalManches" :disabled="marqueurEstimation == null" @confirmer="confirmerEstimation"
          @suivant="mancheSuivante" @terminer="terminerJeu" />
        <div v-if="!freeze" class="timer-bg">
          <div class="timer" :style="{ width: (time / maxTime) * 100 + '%' }"></div>
        </div>
        <GameResult v-if="confirme && distance !== null" :distance="distance" :pointsManche="pointsManche" />
      </div>
      <GameMap :coordCible="coordCible" :confirme="confirme" @marqueur-place="mettreAJourEstimation" ref="gameMap" />
    </header>

    <div class="game" :style="{ backgroundImage: 'url( ' + currentImageUrl + ' )' }">

    </div>
  </section>
  <section v-if="partieFini" :style="{ backgroundImage: 'url(' + this.currentImageUrl + ')' }">
    <div class="result">
      <h2>Resultat de la partie</h2>
      <p>Score Total: {{ scoreGlobal }}</p>
      <p>Manches: {{ totalManches }}</p>
      <p>Score Moyen/Manche: {{ scoreGlobal / totalManches }}</p>
      <button @click="$router.push('/')">Quitter</button>
    </div>
  </section>
</template>

<script>
import GameMap from '@/components/Game/GameMap.vue';
import GameControls from '@/components/Game/GameControls.vue';
import GameResult from '@/components/Game/GameResult.vue';
import { GATEWAY_API } from "@/config.js";
import { useAuthStore } from '@/stores/pinia';

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
      freeze: false,
      currentImageUrl: "",
      partieFini: false,
      difficulte: 1,
      serieId: 1
    }
  },
  methods: {
    async recupererDonneesCible() {
      try {
        this.$api.get("/parties/" + this.authStore.idPartie + "/next", {
          headers: {
            'Authorization': `Bearer ${this.authStore.tokenUser}`,
            'PartieAuthorization': `${this.authStore.tokenPartie}`
          }
        }).then(res => {
          console.log(res.data);
          this.currentImageUrl = `${GATEWAY_API}/assets/${res.data.coup.idImage}`;
          this.totalManches = res.data.coup.nbCoupsTotal;
          this.time = res.data.coup.secondesRestantes;
          this.manche = this.totalManches - res.data.coup.nbCoupsRestants + 1;
        })
      } catch (error) {
        console.error(error);
      }
    },
    mettreAJourEstimation(coord) {
      this.marqueurEstimation = coord
    },
    confirmerEstimation(timeout = false) {
      this.$api.post("/parties/" + this.authStore.idPartie + "/confirmer", {
        lat: timeout ? 0 : this.marqueurEstimation?.lat,
        long: timeout ? 0 : this.marqueurEstimation?.lon
      }, {
        headers: {
          'Authorization': `Bearer ${this.authStore.tokenUser}`,
          'PartieAuthorization': `${this.authStore.tokenPartie}`
        }
      }).then(res => {
        this.coordCible = { lat: res.data.lat, lon: res.data.lon }

        this.confirme = true

        if (!timeout) {
          this.$refs.gameMap.afficherResultats(this.coordCible, this.marqueurEstimation)
          this.distance = this.$refs.gameMap.calculerDistance(this.coordCible, this.marqueurEstimation)
        }

        this.pointsManche = res.data.score - this.scoreGlobal;
        this.freeze = true;
      })

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
      this.partieFini = true;
    }
  },
  computed: {
    authStore() {
      return useAuthStore();
    }
  },
  mounted() {
    this.recupererDonneesCible();
    this.timeInterval = setInterval(() => {
      if (!this.freeze) {
        if (this.time > 0) {
          this.time--;
        } else {
          this.freeze = true;
          this.confirmerEstimation(true);
        }
      }
    }, 1000);
  }
}
</script>

<style scoped>
header {
  height: calc(100vh - 70px);
  background: #181818;
  width: 40%;
  display: flex;
  justify-content: space-between;
  flex-direction: column;
  border-right: 3px solid #181818;
  transition: all 0.3s ease;
  font-size: larger;
}

section {
  display: flex;
  flex-direction: row;
  height: calc(100vh - 70px);
  color: white;
  background-size: cover;
  background-position: center;
}

.result {
  display: inline-block;
  background: #181818;
  padding: 40px 80px;
  height: auto;
  text-align: center;

}

.game {
  width: 60%;
  background-size: contain;
  background-repeat: no-repeat;
  background-color: #181818;
  background-position: center;
  transition: all 0.3s ease;
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
  transition: width 0.3s ease;
}

.result button {
  padding: 6px 12px;
  font-size: 14px;
  background: none;
  color: white;
  border: 0;
  border-radius: 20px;
  border: 2px solid darkorange;
  color: darkorange;
  margin-top: 20px;
  margin-right: 10px;
}

.result button:hover {
  background: darkorange;
  color: black;
}

/* Responsive Design */

/* Tablettes */
@media (max-width: 1024px) {
  header {
    width: 40%;
    height: calc(100vh - 70px);
  }

  .game {
    width: 60%;
  }

  .info-cible {
    padding: 10px 40px;
  }
}

/* Smartphones */
@media (max-width: 768px) {
  section {
    flex-direction: column;
    overflow: hidden;
    height: 80%;
    min-height: fit-content;
  }

  header {
    width: 100%;
    height: auto;
    border-right: none;
    border-bottom: 3px solid #181818;
  }

  .game {
    width: 100%;
    height: calc(100vh - 200px);
  }

  .info-cible {
    padding: 10px 40px;
  }

  .timer-bg {
    height: 8px;
  }
}

/* Très petits écrans */
@media (max-width: 480px) {

  .info-cible h2,
  .info-cible h3,
  .info-cible p {
    font-size: 0.9em;
  }

  .game {
    height: calc(100vh - 180px);
  }

  .timer-bg {
    height: 6px;
  }
}
</style>
