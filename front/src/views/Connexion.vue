<template>
   <div class="bg"></div>
  <div v-if="!authStore.isAuthenticated" class="connexion">
    <div class="switch">
      <button
        :class="{ active: vueActive === 'Login' }"
        @click="switchView('Login')">
        Connexion
      </button>
      <button
        :class="{ active: vueActive === 'Signup' }"
        @click="switchView('Signup')">
        Inscription
      </button>
    </div>

    <transition name="fade-slide" mode="out-in">
      <component v-if="!authStore.isAuthenticated" :is="vueActive" key="vueActive"></component>
    </transition>
  </div>
  <div v-else class="deconnexion" style="height: auto;">
    <p>Etes vous sur de vous déconnecter du site ?</p>
    <button @click="logout" id="Logout">Oui je veux</button>
  </div>
</template>

<script>
import Login from '@/components/Connexion/Login.vue';
import Signup from '@/components/Connexion/Signup.vue';
import { useAuthStore } from '@/stores/pinia';

export default {
  name: 'Connexion',
  components: { Login, Signup },
  data() {
    return {
      vueActive: 'Login',
    };
  },
  mounted() {
    const vueFromQuery = this.$route.query.vueActive;
    if (vueFromQuery === 'Signup' || vueFromQuery === 'Login') {
      this.vueActive = vueFromQuery;
    }
  },
  methods: {
    switchView(view) {
      this.vueActive = view;
    },
    logout() {
      this.authStore.logout();
      this.isLoggedIn = false;
      this.vueActive = 'Login';
      this.$router.push({ name: 'Home' });
    }
  },
  computed: {
      authStore() {
        return useAuthStore();
      }
  },
};
</script>

<style scoped>

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
    z-index: -1;
  }

.connexion, .deconnexion {
  text-align: center;
  border-radius: 20px;
  padding: 20px;
  background: rgba(24, 24, 24, 0.85);
  width: 400px;
  height: auto;
  margin: 60px auto;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  transition: all 0.3s ease;
}

.deconnexion {
  border: 2px solid red;
  height: auto;
}

.switch {
  text-align: center;
  margin: 20px auto;
  display: flex;
  justify-content: center;
  gap: 10px;
  flex-wrap: wrap;
}

.deconnexion p {
  color: white;
}

button {
  margin: 0 10px;
  padding: 8px 16px;
  font-size: 1em;
  border: 2px solid darkorange;
  border-radius: 20px;
  background: white;
  color: darkorange;
  cursor: pointer;
  transition: all 0.3s ease;
  min-width: 120px;
}

button:hover {
  background: darkorange;
  color: black;
}

button.active {
  background: darkorange;
  color: black;
  font-weight: bold;
  transform: scale(1.1);
}

#Logout {
  margin: 20px auto;
  padding: 16px 32px;
  font-size: 1em;
  border: 2px solid red;
  border-radius: 32px;
  background: red;
  color: white;
  cursor: pointer;
  transition: all 0.3s ease;
  font-size: large;
  font-weight: bold;
  display: block;
  width: 80%;
  max-width: 300px;
}

#Logout:hover {
  background: white;
  color: red;
}

/* Transition Animations */
.fade-slide-enter-active,
.fade-slide-leave-active {
  transition: all 0.25s ease;
}

.fade-slide-enter-from {
  opacity: 0;
  transform: translateY(20px);
}

.fade-slide-enter-to {
  opacity: 1;
  transform: translateY(0);
}

.fade-slide-leave-from {
  opacity: 1;
  transform: translateY(0);
}

.fade-slide-leave-to {
  opacity: 0;
  transform: translateY(-20px);
}

/* Responsive Design */
@media (max-width: 768px) {
  .connexion, .deconnexion {
    width: 90%;
    padding: 15px;
    margin: 20px auto;
  }

  button {
    padding: 10px 20px;
    font-size: 0.9em;
    margin: 5px;
    min-width: 100px;
  }

  #Logout {
    padding: 12px 24px;
    font-size: 1em;
    width: 90%;
  }
}

@media (max-width: 480px) {
  .connexion, .deconnexion {
    width: 95%;
    padding: 10px;
  }

  button {
    padding: 8px 16px;
    font-size: 0.85em;
    min-width: 80px;
  }

  #Logout {
    padding: 10px 20px;
    font-size: 0.9em;
  }
}

</style>
