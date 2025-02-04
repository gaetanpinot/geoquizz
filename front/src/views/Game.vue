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
            <div class="timer"></div>
          </div>
          <!-- Компонент результата, отображается только если distance вычислена -->
          <GameResult v-if="confirme && distance !== null" :distance="distance" :pointsManche="pointsManche" />
        </div>
        <GameMap
          :coordCible="coordCible"
          :confirme="confirme"
          @marqueur-place="mettreAJourEstimation"
          ref="gameMap"
        />
      </header>

      <div class="game" style="background-image: url(https://upload.wikimedia.org/wikipedia/commons/3/3c/Vue_de_nuit_de_la_Place_Stanislas_%C3%A0_Nancy.jpg)">

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
        // Здесь будем сохранять координаты, полученные из события (формат: { lat, lon })
        marqueurEstimation: null,
        confirme: false,
        distance: null,
        pointsManche: 0,
        scoreGlobal: 0
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
          // Если данные не получены – используем значения по умолчанию (Nancy)
          this.coordCible = { lat: 48.692054, lon: 6.184417 }
          this.imageCible = "https://via.placeholder.com/300x200?text=Image+Cible+Nancy"
        }
      },
      mettreAJourEstimation(coord) {
        // Обновляем координаты, полученные от подкомпонента GameMap
        this.marqueurEstimation = coord
      },
      confirmerEstimation() {
        if (!this.marqueurEstimation) return
        this.confirme = true
        // Вызов метода отображения результата (маркер cible + линия) из GameMap
        this.$refs.gameMap.afficherResultats(this.coordCible, this.marqueurEstimation)
        // Вычисляем расстояние с помощью метода calculerDistance из GameMap
        this.distance = this.$refs.gameMap.calculerDistance(this.coordCible, this.marqueurEstimation)

        // Система оценивания: максимальное количество очков (например, 1000) уменьшается в зависимости от расстояния
        const maxPoints = 1000
        const maxDistance = 1000000 // 1 000 000 м (примерно 1000 км)
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
        // Дополнительная логика завершения игры может быть добавлена здесь
      }
    },
    mounted() {
      this.recupererDonneesCible()
    }
  }
  </script>

  <style scoped>

  header {
    background: #181818;
    width: 30%;
    height: calc(100vh - 70px);
    display: flex;
    justify-content: space-between;
    flex-direction: column-reverse;
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
