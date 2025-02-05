import { createRouter, createWebHistory } from 'vue-router'
import Home from '@/views/Home.vue'
import Game from '@/views/Game.vue'
import Connexion from '@/views/Connexion.vue'
import GameList from '@/views/GameList.vue'

const router = createRouter({
    history: createWebHistory(
        import.meta.env.BASE_URL),
    routes: [
        { path: '/', name: 'Home', component: Home },
        { path: '/Connexion', name: 'Connexion', component: Connexion },
        { path: '/game', name: 'Game', component: Game }
    ],
})

export default router