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
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';

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
        toast("Les mots de passe ne correspondent pas.", {
          autoClose: 1000,
          type: "error"
        });
        return;
      }
      this.$api.post("/signup", {
        email: this.email,
        password: this.motDePasse
      }).then(res => {
        if (res.status === 201) {
          localStorage.setItem("token", res.data.data.access_token);
          this.$router.go("/");
        } else {
          toast("Adresse email déjà existante.", {
            autoClose: 1000,
            type: "error"
          });
        }
      })
    }
  }
}
</script>

<style scoped>
.signup {
  text-align: center;
  margin-top: 20px;
}
.signup form {
  display: inline-block;
  width: 100%;
}
.signup input {
  display: block;
  margin: 10px 0;
  padding: 8px;
  width: 200px;
}
.signup button[type="submit"] {
  padding: 8px 16px;
  font-size: 1em;
  background: none;
  color: white;
  border: 0;
  border-radius: 20px;
  border: 2px solid darkorange;
  color: orange;
  margin-top: 12px;
}
.signup button[type="submit"]:hover {
  background: darkorange;
  transition: 0.3s;
  color: black;
}
.signup input[type="email"],
.signup input[type="password"] {
  width: 80%;
  border: 2px solid darkorange;
  border-radius: 20px;
  padding: 10px;
  margin: 10px auto;

}
.signup input:focus {
  outline: none;
}
</style>
