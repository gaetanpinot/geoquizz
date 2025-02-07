<template>
  <div class="signup">
    <h2>Inscription</h2>
    <form @submit.prevent="sInscrire">
      <input v-model="email" type="email" placeholder="Email" required>
      <input v-model="nom" type="text" placeholder="Nom" required>
      <input v-model="prenom" type="text" placeholder="Prénom" required>
      <input v-model="motDePasse" type="password" placeholder="Mot de passe" required>
      <input v-model="motDePasseConfirmation" type="password" placeholder="Confirmer le mot de passe" required>
      <button type="submit">S'inscrire</button>
    </form>
  </div>
</template>

<script>
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
import { useAuthStore } from '@/stores/pinia';

export default {
  name: 'Signup',
  data() {
    return {
      email: '',
      motDePasse: '',
      motDePasseConfirmation: '',
      nom: '',
      prenom: ''
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
        password: this.motDePasse,
        nom: this.nom,
        prenom: this.prenom
      }).then(res => {
        if (res.status === 201) {
          this.authStore.setTokenUser(res.data.data.access_token);
          setTimeout(() => {
            this.$router.push("/");
          }, 500);
        } else {
          toast("Adresse email déjà existante.", {
            autoClose: 1000,
            type: "error"
          });
        }
      })
    }
  },
  computed: {
      authStore() {
       return useAuthStore();
      }
  },
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
.signup input {
  width: 80%;
  border: 2px solid darkorange;
  border-radius: 20px;
  padding: 10px;
  margin: 10px auto;

}
.signup input:focus {
  outline: none;
}

h2 {
  color: white;
}
</style>
