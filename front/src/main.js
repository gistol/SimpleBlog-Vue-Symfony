import Vue from 'vue';
import App from './App.vue';

import store from './store';

import env from './env';
import axios from 'axios';

axios.defaults.baseURL = env.API_URL;
window.axios = axios;

Vue.config.productionTip = false;

new Vue({
    store,
    render: h => h(App)
}).$mount('#app');
