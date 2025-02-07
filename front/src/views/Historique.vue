<template>
  <section>
    <div class="history">
      <h2>Historique des parties</h2>
      <div v-if="loading">Chargement...</div>
      <div v-else-if="error">{{ error.message }}</div>
      <div v-else>
        <div v-for="game in games" :key="game.id" class="game-item">
          <p>
            {{ game.date || "Date inconnue" }} - Série {{ game.id_serie }} - {{ game.score }} points
            <button @click="replayGame(game)">Rejouer</button>
          </p>
        </div>
      </div>
    </div>
    <br>
    <div class="history">
      <h2>Meilleurs Scores par Série</h2>
      <div v-for="(score, serieId) in highScoresPerSeries" :key="serieId">
        <p>Série {{ serieId }} : {{ score }} points</p>
      </div>
    </div>
    <br>
    <div class="profile">
      <h2>Votre Profil</h2>
      <div>
        <p>Nom : {{ authStore.user ? authStore.user.nom : 'N/A' }}</p>
      </div>
      <div>
        <p>Prénom : {{ authStore.user ? authStore.user.prenom : 'N/A' }}</p>
      </div>
      <div>
        <p>Email : {{ authStore.user ? authStore.user.email : 'N/A' }}</p>
      </div>
    </div>
  </section>
</template>
<script>
import { useAuthStore } from '@/stores/pinia';
export default {
  name: 'GameHistory',
  data() {
    return {
      games: [],
      loading: false,
      error: null,
    };
  },
  computed: {
    authStore() {
      return useAuthStore();
    },
    highScoresPerSeries() {
      const scores = {};
      console.log(this.games)
      this.games.forEach((game) => {
        if (!scores[game.id_serie] || game.score > scores[game.id_serie]) {
          scores[game.id_serie] = game.score;
        }
      });
      return scores;
    },
  },
  methods: {
    async fetchGames() {
      this.loading = true;
      try {
        const res = await this.$api.get('/historique', {
          headers: {
            'Authorization': `Bearer ${this.authStore.tokenUser}`,
          },
        });
        console.log(res);
        this.games = res.data.parties;
      } catch (err) {
        this.error = err;
        console.error("Erreur de récupération des parties", err);
      } finally {
        this.loading = false;
      }
    },
    replayGame(game) {
      this.$router.push({
        name: 'Game',
        query: {
          mode: 'replay',
          gameId: game.id,
          difficulty: game.difficulte,
        },
      });
    },
  },
  mounted() {
    this.fetchGames();
  },
};
</script>
<style scoped>
section {
  padding: 50px;
  background: #242424;
  color: #f7f7f7;
  min-height: calc(100vh - 70px);
}
.history {
  margin-bottom: 30px;
}
.game-item {
  margin: 10px 0;
  padding: 10px;
  border-bottom: 1px solid #444;
}
.profile {
  margin-top: 30px;
  padding: 20px;
  background: #323232;
  border-radius: 8px;
}
</style>