<template>
  <div class="game-list">
    <h1>Liste des jeux</h1>
    <ul>
      <li v-for="game in games" :key="game.id">
        <span>{{ game.title }} - {{ game.status }}</span>
        <button @click="replayGame(game)">Rejouer</button>
        <button v-if="game.status === 'En cours'" @click="continueGame(game)">Continuer</button>
      </li>
    </ul>
    <button @click="nouvellePartie = true">Nouvelle Partie</button>
    <div v-if="nouvellePartie" class="new-game-form">
      <h2>Créer une nouvelle partie</h2>
      <form @submit.prevent="creerNouvellePartie">
        <div>
          <label for="difficulty">Difficulté (Distance D en mètres) :</label>
          <input id="difficulty" type="number" v-model.number="nouvelleGame.difficulty" required>
        </div>
        <button type="submit">Créer la partie</button>
        <button type="button" @click="nouvellePartie = false">Annuler</button>
      </form>
    </div>
  </div>
</template>
<script>
import { BASE_GAME_API } from '@/config';
export default {
  name: 'GameList',
  data() {
    return {
      games: [],
      nouvellePartie: false,
      nouvelleGame: {
        difficulty: 100, 
      }
    }
  },
  methods: {
    async fetchGames() {
      console.log('get List')
      try {
        const response = await fetch(`${BASE_GAME_API}/partie`);
        if (!response.ok) {
          throw new Error('Erreur lors de la récupération des parties');
        }
        const data = await response.json();
        console.log(data)
        this.games = data.parties.map(game => ({
          ...game,
          title: `Partie #${game.id}`,
          status: game.status === 1 ? 'En cours' : 'Terminé'
        }));
      } catch (error) {
        console.error(error);
      }
    },
    replayGame(game) {
      console.log('Rejouer la partie', game);
    },
    continueGame(game) {
      console.log('Continuer la partie', game);
    },
    async creerNouvellePartie() {
      console.log('Créer une nouvelle partie avec paramètres:', this.nouvelleGame);
      const newGameBody = {
        id_serie: 1,  
        id_joueur: "a0eebc99-9c0b-4ef8-bb6d-6bb9bd380a11", 
        status: 1,
        difficulte: this.nouvelleGame.difficulty,
        score: 0     
      };
      try {
        console.log('creation')
        const response = await fetch(`${BASE_GAME_API}/partie`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(newGameBody) 
        });
        if (!response.ok) {
          throw new Error('Erreur lors de la création de la partie');
        }
        console.log("OK")
        const createdGame = await response.json();
        createdGame.title = `Partie #${createdGame.id}`;
        createdGame.status = createdGame.status === 1 ? 'En cours' : 'Terminé';
        this.games.push(createdGame);
        this.$router.push({
          name: 'Game',
          query: {
            mode: 'new',
            gameId: createdGame.id,
            difficulty: createdGame.difficulte,
          }
        });
        this.nouvellePartie = false;
        this.nouvelleGame = { difficulty: 100};
      } catch (error) {
        console.error('Erreur création nouvelle partie', error);
      }
    }
  },
  mounted() {
    this.fetchGames();
  }
}
</script>
<style scoped>
.game-list {
  text-align: center;
}
.game-list ul {
  list-style: none;
  padding: 0;
}
.game-list li {
  margin: 10px 0;
}
.new-game-form {
  margin-top: 20px;
  border: 1px solid #ccc;
  padding: 20px;
  display: inline-block;
}
.new-game-form form div {
  margin: 10px 0;
}
</style>
