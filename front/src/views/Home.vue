<template>
  <main>
   <div class="bg"></div>
    <div class="info">
      <h1>📌 GEOQUIZZ</h1>
      <p>Devinez l'endroit d'ou se situe l'image et gagnez des points en faissant appel a votre rapidité!</p>
      <span>
        <button>S'inscrire</button>
        <button class="create">Créer une partie</button>
      </span>
    </div>
  </main>
</template>

<script>
export default {
  name: 'Home'
}
</script>

<style>
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

  main div.info {
    position: relative;
    text-align: center;
    max-width: 700px;
    background: rgba(24, 24, 24, 0.85);
    padding: 50px 100px;
    border-radius: 20px;
  }

  main h1 {
    font-size: 50px;
  }

  main p {
    font-size: 20px;
  }

  main button {
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

  main button:hover {
    background: darkorange;
    color: black;
  }

  main button.create {
    border: 3px solid cadetblue;
    background: cadetblue;
    color: black;
  }

</style>
