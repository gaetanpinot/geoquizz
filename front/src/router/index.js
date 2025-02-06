import { createRouter, createWebHistory } from 'vue-router'
import Home from '@/views/Home.vue'
import Game from '@/views/Game.vue'
import Connexion from '@/views/Connexion.vue'
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
import Historique from "@/views/Historique.vue";

const router = createRouter({
    history: createWebHistory(
        import.meta.env.BASE_URL),
    routes: [
        { path: '/', name: 'Home', component: Home },
        { path: '/Connexion', name: 'Connexion', component: Connexion },
        { path: '/game', name: 'Game', component: Game, meta: { requiresAuth: true } },
        { path: '/Historique', name: 'Historique', component: Historique, meta: { requiresAuth: true } }
    ],
})

export default router

router.beforeEach((to, from, next) => {
  const token = localStorage.getItem('token')

  if (to.meta.requiresAuth && !token) {
    toast("Veuillez vous connecter pour accéder ici.", {
      autoClose: 1000,
      type: "error"
    });
  } else {
    next()
  }
})
