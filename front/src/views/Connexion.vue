<template>
    <div class="connexion">
      <div class="switch">
        <button @click="vueActive = 'Login'">Se connecter</button>
        <button @click="vueActive = 'Signup'">S'inscrire</button>
      </div>
      <component :is="vueActive"></component>
    </div>
  </template>
  
  <script>
  import Login from '@/components/Connexion/Login.vue';
  import Signup from '@/components/Connexion/Signup.vue';
  export default {
    name: 'Connexion',
    components: { Login, Signup },
    data() {
      return { vueActive: 'Login' }
    }
  }
  </script>
  
  <style scoped>
  .switch {
    text-align: center;
    margin-bottom: 20px;
  }
  .switch button {
    margin: 0 10px;
    padding: 8px 16px;
  }
  </style>
  