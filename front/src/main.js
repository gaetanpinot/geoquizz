import { createApp } from 'vue'
import { createPinia } from 'pinia'
import apiPlugin from './plugins/api';

import {GATEWAY_API} from './config.js';

const pinia = createPinia();
import piniaPersist from 'pinia-plugin-persistedstate';
pinia.use(piniaPersist);


const apiConfig = {
  baseURL: GATEWAY_API
};

import App from './App.vue'
import router from './router'

const app = createApp(App)

app.use(router)
app.use(apiPlugin, apiConfig)
app.use(pinia);
app.mount('#app')
