import Vue from 'vue';
import App from './App.vue';
import Resource from 'vue-resource';

import Bootstrap from 'bootstrap-vue'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

import store from './store';
import router from './router';

import env from './env';

Vue.use(Resource);
Vue.use(Bootstrap);

Vue.http.options.root = env.API_URL;
Vue.http.interceptors.push((request, next) => {
    if(localStorage.getItem('token'))
        request.headers.set('Authorization', 'Bearer ' + localStorage.getItem('token'));

    next(response => {
        if(response.status === 400 || response.status === 401 || response.status === 403)
            router.push({path: '/login'});
    });
});

Vue.config.productionTip = false;

new Vue({
    store,
    router,
    render: h => h(App)
}).$mount('#app');
