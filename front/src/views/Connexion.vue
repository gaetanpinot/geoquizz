<template>
  <div class="connexion">
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
      <component :is="vueActive" key="vueActive"></component>
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
      vueActive: 'Login'
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

.switch button {
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

.switch button:hover {
  background: darkorange;
  color: black;
}

.switch button.active {
  background: darkorange;
  color: black;
  font-weight: bold;
  transform: scale(1.2);
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
