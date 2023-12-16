import '../css/app.css'
import './bootstrap';

import { createApp } from 'vue';
import App from './App.vue'
import router from './router';
import './axios.js'

createApp(App).use(router).mount("#app");

console.log("vue-app");
