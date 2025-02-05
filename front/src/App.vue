<template>
  <div id="app">
    <nav>
      <h1>GEOQUIZZ</h1>
      <span>
         <router-link to="/">Accueil</router-link>
         <router-link to="/Connexion">Connexion</router-link>
         <router-link to="/game"><button>Jouer</button></router-link>
      </span>
    </nav>
    <router-view />
  </div>
</template>

<script>
export default {
  name: 'App'
}
</script>

<style>
  @import url('https://fonts.googleapis.com/css2?family=Jersey+10&family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap');
  * {
    box-sizing: border-box;
    margin: 0;
  }
  html{
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
    border: 2px solid darkorange;
    color: orange;
  }

  nav button:hover {
    background: darkorange;
    transition: 0.3s;
    color: black;
  }
</style>
