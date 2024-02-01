import '../css/app.css'
import './bootstrap';

import { createApp } from 'vue';
import App from './App.vue'
import router from './router';
import './axios.js'


import { createPinia } from 'pinia'
import piniaPluginPersistedstate from 'pinia-plugin-persistedstate'
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.all.js';
const pinia = createPinia()
pinia.use(piniaPluginPersistedstate)

createApp(App).use(router).use(pinia).use(VueSweetalert2).mount('#app')
