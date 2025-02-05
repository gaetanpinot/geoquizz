<template>
  <main>
   <div class="bg"></div>
    <div class="info">
      <h2>📌 GEOQUIZZ</h2>
      <p>Devinez l'endroit d'ou se situe l'image et gagnez des points en faissant appel a votre rapidité!</p>
      <span>
        <router-link  to="/Connexion"><button>S'inscrire / Se connecter</button></router-link>
        <router-link to="/game"><button class="create">Créer une partie</button></router-link>
      </span>
    </div>
  </main>
</template>

<script>
export default {
  name: 'Home'
}
</script>

<style scoped>
  main {
    height: calc(100vh - 70px);
    position: relative;
    background: #181818;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    color: white;
  }

  .bg {
    position: absolute;
    top: 0;
    right: 0;
    left: 0;
    bottom: 0;
    background-image: url(https://a.travel-assets.com/findyours-php/viewfinder/images/res70/107000/107029-Place-Stanislas.jpg);
    background-size: cover;
    background-position: center;
    filter: brightness(0.5);
  }
  h2{
    font-size: 50px;
  }
  .info:hover h2 {
    color: darkorange;
  }
  .info {
    position: relative;
    text-align: center;
    max-width: 700px;
    background: rgba(24, 24, 24, 0.85);
    padding: 50px 100px;
    border-radius: 20px;
    box-shadow: 0 0 20px black;
    transition: all 0.3s ease-in-out;
  }
  .info:hover {
    transform: translatey(-20px);
  }

   p {
    font-size: 20px;
  }

   button {
    margin-top: 16px;
    padding: 10px 20px;
    background: none;
    border: 2px solid darkorange;
    color: darkorange;
    font-size: 20px;
    text-transform: uppercase;
    border-radius: 20px;
    margin: 20px 10px;
  }

   button:hover {
    background: darkorange;
    color: black;
  }

   button.create {
    border: 3px solid cadetblue;
    background: cadetblue;
    color: black;
  }

</style>
