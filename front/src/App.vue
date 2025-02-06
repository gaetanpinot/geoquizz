<template>
  <div id="app">
    <nav>
      <router-link to="/"><h1>GEOQUIZZ</h1></router-link>
      <span>
         <router-link to="/"><button>Accueil</button></router-link>
         <router-link  to="/Historique">
            <button v-if="isAuthenticated">Historique</button>
         </router-link>
         <router-link  to="/Connexion">
            <button v-if="!isAuthenticated">Connexion</button>
            <button v-else>Déconnexion</button>
         </router-link>
         <button @click="createGame()" id="Game">Jouer</button>
      </span>
    </nav>
    <CreateGame ref="popup" />
    <router-view />
  </div>
</template>

<script>
import CreateGame from './views/CreateGame.vue';

export default {
  name: 'App',
  components: {
    CreateGame
  },
  computed: {
    isAuthenticated() {
      return localStorage.getItem('token') !== null;
    }
  },
  methods: {
    createGame() {
      this.$refs.popup.openPopup();
    }
  }
}
</script>

<style>
  @import url('https://fonts.googleapis.com/css2?family=Jersey+10&family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap');
  * {
    box-sizing: border-box;
    margin: 0;
  }

  html {
    background: #f1f1f1;
  }

  nav {
    background: #181818;
    padding: 0 20px;
    height: 70px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    color: white;
    position: relative;
    z-index: 500;
  }

  nav h1 {
    font-size: 30px;
    border-radius: 20px;
  }

  nav h1:hover {
    color: darkorange;
    transition: all 0.3s;
  }

  nav a {
    color: white;
    text-decoration: none;
  }

  html, body, button {
    margin: 0;
    padding: 0;
    font-family: "Kanit", serif;
    font-weight: 400;
    font-style: normal;
  }

  nav span {
    display:  flex;
    gap: 14px;
    align-items: center;
  }

  nav button {
    padding: 6px 12px;
    font-size: 14px;
    background: none;
    color: white;
    border: 0;
    border-radius: 20px;
    color: white;
  }

  nav #Game {
    padding: 6px 12px;
    font-size: 14px;
    background: none;
    color: white;
    border: 0;
    border-radius: 20px;
    border: 2px solid darkorange;
    color: orange;
  }

  nav #Game:hover {
    background: darkorange;
    transition: 0.3s;
    color: white;
  }

  button {
    cursor: pointer;
  }
</style>
