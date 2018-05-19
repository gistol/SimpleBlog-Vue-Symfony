import Vue from 'vue';
import Router from 'vue-router';

import Home from './../views/Home';
import LoginComponent from './../components/auth/Login';
import RegisterComponent from './../components/auth/Register';
import HomeComponent from './../components/home/Home';


Vue.use(Router);

export default new Router({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'homepage',
            component: Home,
            children: [
                {
                    path: '/',
                    name: 'home',
                    component: HomeComponent,
                },
                {
                    path: '/login',
                    name: 'login',
                    component: LoginComponent,
                },
                {
                    path: '/register',
                    name: 'register',
                    component: RegisterComponent,
                }
            ]

        }
    ]
});
