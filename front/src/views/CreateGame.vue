<template>
  <div v-if="isVisible" class="overlay">
    <div class="popup">
      <h2>Créer une partie</h2>
      <br>
      <div>
        <p>Série de jeu</p>
        <select v-model="selectValue">
          <option v-for="item in series" :key="item.id" :value="item.id">{{ item.nom }}</option>
        </select>
      </div>
      <div>
        <p>Niveau de difficulté: {{difficulty}}</p>
        <input v-model="difficulty" type="range" min="1" max="5"/>
      </div>
      <button @click="createGame()">Créer</button>
      <button @click="closePopup()">Fermer</button>
    </div>
  </div>
</template>

<script>
import {toast} from "vue3-toastify";
import { useAuthStore } from "@/stores/pinia";
export default {
  data() {
    return {
      isVisible: false,
      difficulty: 1,
      selectValue: 1,
      series: []
    };
  },
  methods: {
    openPopup() {
      if(this.authStore.tokenUser == null) {
        toast("Veuillez vous connecter pour créer une partie.", {
          autoClose: 1000,
          type: "error"
        });
        return;
      }
      this.isVisible = true;
    },
    closePopup() {
      this.isVisible = false;
    },
    createGame() {
      this.$api.post("/parties", {
        "id_serie": parseInt(this.selectValue),
        "difficulte": parseInt(this.difficulty)
      }, {
        headers: {
          'Authorization': `Bearer ${this.authStore.tokenUser}`
        }
      }).then(res => {
        console.log(res);
        if(res.status === 201) {
          this.authStore.setIdPartie(res.data.id);
          this.isVisible = false;
          setTimeout(() => {
            this.$router.push("/game");
          }, 500);
        }
      })
    }
  },
  computed: {
      authStore() {
       return useAuthStore();
      }
  },
  mounted() {
    this.$api.get("/series").then(res => {
      this.series = res.data.series;
    })
  }
};
</script>

<style scoped>
.overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent background */
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 700;
}

.popup {
  background-color: #181818;
  padding: 40px 80px;
  border-radius: 5px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
  color: white;
  width: 500px;
}

button {
  padding: 8px 16px;
  font-size: 16px;
  background: none;
  color: white;
  border: 0;
  border-radius: 20px;
  border: 2px solid darkorange;
  color: orange;
  margin-top: 12px;
  margin-right: 8px;
}

button:hover {
  background-color: darkorange;
  color: black;
}

/*********** Baseline, reset styles ***********/
input[type="range"] {
  -webkit-appearance: none;
  appearance: none;
  background: transparent;
  cursor: pointer;
  width: 100%;
}

/* Removes default focus */
input[type="range"]:focus {
  outline: none;
}

/******** Chrome, Safari, Opera and Edge Chromium styles ********/
/* slider track */
input[type="range"]::-webkit-slider-runnable-track {
  background-color: #ff8c00;
  border-radius: 0.5rem;
  height: 0.5rem;
}

/* slider thumb */
input[type="range"]::-webkit-slider-thumb {
  -webkit-appearance: none; /* Override default look */
  appearance: none;
  margin-top: -4px; /* Centers thumb on the track */
  background-color: #ff8c00;
  border-radius: 0.5rem;
  height: 1rem;
  width: 1rem;
}

input[type="range"]:focus::-webkit-slider-thumb {
  outline: 3px solid #c76a00;
  outline-offset: 0.125rem;
}

/*********** Firefox styles ***********/
/* slider track */
input[type="range"]::-moz-range-track {
  background-color: #ff8c00;
  border-radius: 0.5rem;
  height: 0.5rem;
}

/* slider thumb */
input[type="range"]::-moz-range-thumb {
  background-color: #ff8c00;
  border: none; /*Removes extra border that FF applies*/
  border-radius: 0.5rem;
  height: 1rem;
  width: 1rem;
}

input[type="range"]:focus::-moz-range-thumb{
  outline: 3px solid #ff8c00;
  outline-offset: 0.125rem;
}

select {
  padding: 8px 12px;
  border: 0;
  background: #323232;
  color: white;
  font-size: 16px;
  border-radius: 6px;
  margin-top: 12px;
  margin-bottom: 12px;
}
</style>
