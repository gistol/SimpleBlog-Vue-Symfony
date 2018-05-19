import Vue from 'vue';
import Router from 'vue-router';

import Home from './../views/Home';
import LoginComponent from './../components/auth/Login';
import HomeComponenten from './../components/home/Home';


Vue.use(Router);

export default new Router({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home,
            children: [
                {
                    path: '/',
                    name: 'home',
                    component: HomeComponenten,
                },
                {
                    path: '/login',
                    name: 'login',
                    component: LoginComponent,
                }
            ]

        }
    ]
});
