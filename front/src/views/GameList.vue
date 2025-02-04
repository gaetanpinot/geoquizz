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
          <div>
            <label for="timeLimit">Durée max par image (en secondes) :</label>
            <input id="timeLimit" type="number" v-model.number="nouvelleGame.timeLimit" required>
          </div>
          <button type="submit">Créer la partie</button>
          <button type="button" @click="nouvellePartie = false">Annuler</button>
        </form>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    name: 'GameList',
    data() {
      return {
        // Liste factice de jeux
        games: [
          { id: 1, title: 'Jeu 1', status: 'Terminé' },
          { id: 2, title: 'Jeu 2', status: 'En cours' },
          { id: 3, title: 'Jeu 3', status: 'Terminé' }
        ],
        nouvellePartie: false,
        nouvelleGame: {
          difficulty: 100, // valeur par défaut pour D (exemple : 100 m)
          timeLimit: 20    // en secondes
        }
      }
    },
    methods: {
      replayGame(game) {
        console.log('Rejouer la partie', game);
        // Navigation vers la page du jeu en mode "replay"
        this.$router.push({ 
          name: 'Game', 
          query: { mode: 'replay', gameId: game.id, difficulty: game.difficulty || 100, timeLimit: game.timeLimit || 20 }
        });
      },
      continueGame(game) {
        console.log('Continuer la partie', game);
        // Navigation vers la page du jeu en mode "continue"
        this.$router.push({ 
          name: 'Game', 
          query: { mode: 'continue', gameId: game.id, difficulty: game.difficulty || 100, timeLimit: game.timeLimit || 20 }
        });
      },
      creerNouvellePartie() {
        console.log('Créer une nouvelle partie avec paramètres:', this.nouvelleGame);
        // Simuler la création d'une nouvelle partie (le backend retournerait un ID réel)
        const newGameId = Math.floor(Math.random() * 10000);
        const newGame = { 
          id: newGameId, 
          title: `Jeu ${newGameId}`, 
          status: 'En cours', 
          difficulty: this.nouvelleGame.difficulty, 
          timeLimit: this.nouvelleGame.timeLimit 
        };
        this.games.push(newGame);
        // Navigation vers la nouvelle partie
        this.$router.push({ 
          name: 'Game', 
          query: { mode: 'new', gameId: newGameId, difficulty: newGame.difficulty, timeLimit: newGame.timeLimit }
        });
        this.nouvellePartie = false;
        this.nouvelleGame = { difficulty: 100, timeLimit: 20 };
      }
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
  