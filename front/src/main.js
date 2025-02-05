import { createApp } from 'vue'
import { createPinia } from 'pinia'
import apiPlugin from './plugins/api';

const apiConfig = {
  baseURL: 'http://localhost:4000'
};

import App from './App.vue'
import router from './router'

const app = createApp(App)

app.use(createPinia())
app.use(router)
app.use(apiPlugin, apiConfig)

app.mount('#app')
