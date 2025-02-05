<template>
  <div class="connexion">
    <div v-if="isConnected" class="switch">
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

    <div v-else>
      <button @click="logout" id="Logout">Déconnexion</button>
    </div>

    <transition name="fade-slide" mode="out-in">
      <component v-if="isConnected" :is="vueActive" key="vueActive"></component>
    </transition>
  </div>
</template>




<script>
import Login from '@/components/Connexion/Login.vue';
import Signup from '@/components/Connexion/Signup.vue';

export default {
  name: 'Connexion',
  components: { Login, Signup },
  data() {
    return {
      vueActive: 'Login',
      isConnected: false
    };
  },
  mounted() {
    const vueFromQuery = this.$route.query.vueActive;
    if (vueFromQuery === 'Signup' || vueFromQuery === 'Login') {
      this.vueActive = vueFromQuery;
    }
    if (!localStorage.getItem('token')) {
      this.isConnected = true;
    }else {
      this.isConnected = false;
    }
  },
  methods: {
    switchView(view) {
      this.vueActive = view;
    },
    logout() {
      localStorage.removeItem('token');
      this.isLoggedIn = false; // Mettre à jour l'état de connexion
      this.vueActive = 'Login'; // Revenir à la vue de connexion
      this.$router.push({ name: 'Home' }); // Redirection (facultative)
    }
  }
};
</script>




<style scoped>
.connexion {
  text-align: center;
  border: 2px solid darkorange;
  border-radius: 20px;
  padding: 20px;
  background: white;
  width: 400px;
  height: 400px;
  margin: 40px auto;
}

.switch {
  text-align: center;
  margin: 20px auto;
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
}

 button:hover {
  background: darkorange;
  color: black;
}

 button.active {
  background: darkorange;
  color: black;
  font-weight: bold;
  transform: scale(1.2);
}
#Logout{
  margin: 0 10px;
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
  margin-top: 120px;
}
#Logout:hover {
  background: white;
  color: red;
}
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
</style>
