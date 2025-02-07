<template>
  <section>
    <div class="history">
      <h2>Historique des parties</h2>
      <div>
        <div v-for="game in games" :key="game.id" class="game-item">
          <p>
            {{ new Date(game.created_at) || "Date inconnue" }} - Série {{ series.filter(item => item.id === game.id_serie)[0].nom }} - {{ game.score }} points
            <button v-if="game.status === 1" @click="replayGame(game)">Continuer</button>
            <button v-else @click="replayGame(game)">Rejouer</button>
          </p>
        </div>
      </div>
    </div>
    <br>
    <div class="history">
      <h2>Meilleurs Scores par Série</h2>
      <div v-for="(score, serieId) in highScoresPerSeries" :key="serieId">
        {{ series.filter(serie => serie.id === serieId)}}
        <p>Série {{ serieId }} : {{ score }} points</p>
      </div>
    </div>
    <br>
    <div class="profile">
      <h2>Votre Profil</h2>
      <div>
        <p>Nom : {{ userLastName }}</p>
      </div>
      <div>
        <p>Prénom : {{ userName }}</p>
      </div>
      <div>
        <p>Email : {{ userEmail }}</p>
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
      series: [],
      userName: "N/A",
      userLastName: "N/A",
      userEmail: "N/A"
    };
  },
  computed: {
    authStore() {
      return useAuthStore();
    },
    highScoresPerSeries() {
      const scores = {};
      this.games.forEach((game) => {
        if (!scores[game.id_serie] || game.score > scores[game.id_serie]) {
          scores[game.id_serie] = game.score;
        }
      });
      return scores;
    },
  },
  methods: {
    fetchGames() {
        this.$api.get('/historique', {
          headers: {
            'Authorization': `Bearer ${this.authStore.tokenUser}`,
          },
        }).then(res => {
          this.games = res.data;
          console.log(this.games)
        });
    },
    fetchSeries() {
      this.$api.get('/series').then(res => {
        this.series = res.data.series;

      });
    },
    replayGame(game) {
      this.$api.post("/parties", {
        "id_serie": game.id_serie,
        "difficulte": game.difficulte
      }, {
        headers: {
          'Authorization': `Bearer ${this.authStore.tokenUser}`
        }
      }).then(res => {
        this.authStore.setIdPartie(res.data.id);
        this.authStore.setTokenPartie(res.data.token);
        setTimeout(() => {
          this.$router.push("/game");
        }, 500);
      })
    },
    getProfile() {
    this.$api.get("/utilisateur", {
      headers: {
        'Authorization': `Bearer ${this.authStore.tokenUser}`
      }
    }).then(res => {
      this.userName = res.data.utilisateur.prenom;
      this.userLastName = res.data.utilisateur.nom;
      this.userEmail = res.data.utilisateur.email;
    })
    }
  },
  mounted() {
    this.fetchGames();
    this.getProfile();
    this.fetchSeries();
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

button:hover {
  background: darkorange;
  transition: 0.3s;
  color: white;
}
button {
   padding: 6px 12px;
   font-size: 14px;
   background: none;
   border-radius: 20px;
   border: 2px solid darkorange;
   color: orange;
  margin-left: 5px;
 }
</style>
