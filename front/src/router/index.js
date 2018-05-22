import Vue from 'vue';
import Router from 'vue-router';

import Home from './../views/Home';
import Admin from './../views/Admin';

import LoginComponent from './../components/auth/Login';
import RegisterComponent from './../components/auth/Register';
import HomeComponent from './../components/home/Home';
import PostComponent from './../components/home/Post';

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
                    name: 'posts',
                    component: HomeComponent,
                },
                {
                    path: '/login',
                    name: 'login',
                    component: LoginComponent,
                    beforeEnter: (to, from, next) => {
                        if(localStorage.token) next('/');
                        else next();
                    }


                },
                {
                    path: '/register',
                    name: 'register',
                    component: RegisterComponent,
                    beforeEnter: (to, from, next) => {
                        if(localStorage.token) next('/');
                        else next();
                    }
                },
                {
                    path: '/post/:slug',
                    name: 'post',
                    component: PostComponent
                },
                {
                    path: '/:id',
                    name: 'postsPaginate',
                    component: HomeComponent,
                },
            ]
        },
        {
            path: '/admin',
            name: 'admin',
            component: Admin,
            beforeEnter: (to, from, next) => {
                if(localStorage.roles !== 'ROLE_ADMIN') next('/');
                else next();
            }

        }
    ]
});
