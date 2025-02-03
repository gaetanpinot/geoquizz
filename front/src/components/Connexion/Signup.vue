<template>
    <div class="signup">
      <h2>Inscription</h2>
      <form @submit.prevent="sInscrire">
        <input v-model="nom" type="text" placeholder="Nom" required>
        <input v-model="email" type="email" placeholder="Email" required>
        <input v-model="motDePasse" type="password" placeholder="Mot de passe" required>
        <button type="submit">S'inscrire</button>
      </form>
    </div>
  </template>
  
  <script>
  export default {
    name: 'Signup',
    data() {
      return {
        nom: '',
        email: '',
        motDePasse: ''
      }
    },
    methods: {
      sInscrire() {
        // Здесь реализуйте логику регистрации
        console.log('Inscription:', this.nom, this.email, this.motDePasse)
      }
    }
  }
  </script>
  
  <style scoped>
  .signup {
    text-align: center;
  }
  .signup form {
    display: inline-block;
  }
  .signup input {
    display: block;
    margin: 10px 0;
    padding: 8px;
    width: 200px;
  }
  </style>
  