<template>
    <div class="login">
      <h2>Connexion</h2>
      <form @submit.prevent="seConnecter">
        <input v-model="email" type="email" placeholder="Email" required>
        <input v-model="motDePasse" type="password" placeholder="Mot de passe" required>
        <button type="submit">Se connecter</button>
      </form>
    </div>
  </template>
  
  <script>
  export default {
    name: 'Login',
    data() {
      return {
        email: '',
        motDePasse: ''
      }
    },
    methods: {
      seConnecter() {
        console.log('Connexion:', this.email, this.motDePasse)
      }
    }
  }
  </script>
  
  <style scoped>
  .login {
    text-align: center;
  }
  .login form {
    display: inline-block;
  }
  .login input {
    display: block;
    margin: 10px 0;
    padding: 8px;
    width: 200px;
  }
  </style>
  