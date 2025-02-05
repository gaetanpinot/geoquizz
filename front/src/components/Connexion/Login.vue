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
  import { toast } from 'vue3-toastify';
  import 'vue3-toastify/dist/index.css';

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
        this.$api.post("/login", {
          email: this.email,
          password: this.motDePasse
        }).then(res => {
          if (res.status === 201) {
            console.log(res.data.data.access_token)
            localStorage.setItem("token", res.data.data.access_token);
            setTimeout(() => {
              this.$router.push("/");
            }, 500);
          } else {
            toast("Email ou mot de passe incorrect.", {
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
  .login {
    text-align: center;
  }
  .login form {
    display: inline-block;
    width: 100%;
  }
  .login input {
    display: block;
    margin: 10px 0;
    padding: 8px;
    width: 200px;
  }
  .login button[type="submit"] {
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
  .login button[type="submit"]:hover {
    background: darkorange;
    transition: 0.3s;
    color: black;
  }
  .login input[type="email"],
  .login input[type="password"] {
    width: 80%;
    border: 2px solid darkorange;
    border-radius: 20px;
    padding: 10px;
    margin: 10px auto;

  }
  .login input:focus {
    outline: none;
  }
  </style>
