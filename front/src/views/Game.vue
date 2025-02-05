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
          this.coordCible = { lat: 48.692054, lon: 6.184417 }
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
        // Valeurs par défaut (exemple : Nancy)
        this.coordCible = { lat: 48.692054, lon: 6.184417 }
        this.imageCible = "https://via.placeholder.com/300x200?text=Image+Cible+Nancy"
      }
      // Démarrer le chronomètre de la manche
      this.startTime = Date.now();
    },
    mettreAJourEstimation(coord) {
      this.marqueurEstimation = coord;
    },
    async confirmerEstimation() {
      if (!this.marqueurEstimation) return;
      this.confirme = true;
      // Afficher sur la carte le marqueur cible et la ligne reliant les points
      this.$refs.gameMap.afficherResultats(this.coordCible, this.marqueurEstimation);
      // Calculer la distance
      this.distance = this.$refs.gameMap.calculerDistance(this.coordCible, this.marqueurEstimation);
      // Simuler l'envoi des coordonnées au serveur et la récupération du nombre de points
      const response = await this.simulerCalculPoints(this.distance);
      this.pointsManche = response.points;
    },
    async simulerCalculPoints(distance) {
      // Calcul du temps écoulé depuis le début de la manche
      const elapsed = (Date.now() - this.startTime) / 1000;
      // Calcul des points de base en fonction de la distance et de la difficulté D
      let basePoints = 0;
      if (distance < this.difficulty) {
        basePoints = 5;
      } else if (distance < 2 * this.difficulty) {
        basePoints = 3;
      } else if (distance < 3 * this.difficulty) {
        basePoints = 1;
      } else {
        basePoints = 0;
      }
      // Application du coefficient de rapidité
      let multiplier = 1;
      if (elapsed < 5) {
        multiplier = 4;
      } else if (elapsed < 10) {
        multiplier = 2;
      } else if (elapsed > 20) {
        multiplier = 0;
      }
      const points = basePoints * multiplier;
      // Simuler un délai de réponse du serveur (500ms)
      return new Promise((resolve) => {
        setTimeout(() => {
          resolve({ points });
        }, 500);
      });
    },
    mancheSuivante() {
      this.scoreGlobal += this.pointsManche;
      if (this.manche < this.totalManches) {
        this.manche++;
        this.confirme = false;
        this.recupererDonneesCible();
        this.$refs.gameMap.reinitialiserCarte();
      }
    },
    terminerJeu() {
      this.scoreGlobal += this.pointsManche;
      // Ajoutez ici la logique de fin de jeu si nécessaire
    }
  },
  mounted() {
    // Lecture des paramètres envoyés dans l'URL (query)
    if (this.$route.query.difficulty) {
      this.difficulty = parseInt(this.$route.query.difficulty);
    }
    if (this.$route.query.timeLimit) {
      this.timeLimit = parseInt(this.$route.query.timeLimit);
    }
    this.recupererDonneesCible();
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
  }

  </style>
