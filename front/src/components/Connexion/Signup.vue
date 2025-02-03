<template>
  <div class="signup">
    <h2>Inscription</h2>
    <form @submit.prevent="sInscrire">
      <input v-model="email" type="email" placeholder="Email" required>
      <input v-model="motDePasse" type="password" placeholder="Mot de passe" required>
      <input v-model="motDePasseConfirmation" type="password" placeholder="Confirmer le mot de passe" required>
      <button type="submit">S'inscrire</button>
    </form>
  </div>
</template>

<script>
export default {
  name: 'Signup',
  data() {
    return {
      email: '',
      motDePasse: '',
      motDePasseConfirmation: ''
    }
  },
  methods: {
    sInscrire() {
      if (this.motDePasse !== this.motDePasseConfirmation) {
        alert("Les mots de passe ne correspondent pas.");
        return;
      }
      console.log('Inscription:', this.email, this.motDePasse);
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
