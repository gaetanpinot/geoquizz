<template>
  <div class="jeu">
    <h2>Manche {{ manche }} / {{ totalManches }}</h2>
    <p>Score global : {{ scoreGlobal }}</p>

    <div class="info-cible">
      <h3>Déterminez l'emplacement en vous basant sur l'image :</h3>
      <img :src="imageCible" alt="Image de la cible" v-if="imageCible" />
    </div>

    <!-- Composant de la carte -->
    <GameMap 
      :coordCible="coordCible" 
      :confirme="confirme"
      @marqueur-place="mettreAJourEstimation"
      ref="gameMap"
    />

    <!-- Composant des contrôles -->
    <GameControls 
      :marqueurEstimation="marqueurEstimation"
      :confirme="confirme"
      :manche="manche"
      :totalManches="totalManches"
      @confirmer="confirmerEstimation"
      @suivant="mancheSuivante"
      @terminer="terminerJeu"
    />

    <!-- Composant d'affichage du résultat -->
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
      scoreGlobal: 0,
      // Paramètres du niveau (récupérés via query params ou valeurs par défaut)
      difficulty: 100,   // Distance D en mètres
      timeLimit: 20,     // Temps maximum par image en secondes
      startTime: null    // Timestamp du début de la manche
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
}
</script>

<style scoped>
.jeu {
  text-align: center;
}
</style>
