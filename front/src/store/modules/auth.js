import Vue from 'vue';
import jwt from 'jsonwebtoken';
import publicKey from './../../jwt/public';

const state = {
    logged: false,
    registered: false
};

const getters = {
    logged: state => state.logged,
    registered: state => state.registered
};

const actions = {
    login({commit}, loginData) {
        Vue.http.post('auth/login', loginData)
            .then(response => response.json())
            .then(result => {
                jwt.verify(result.token, publicKey, error => {
                    if(!error) {
                        localStorage.setItem('token', result.token);
                        commit('LOGGED');
                    }
                })
            });
    },
    register({commit}, registerData) {
        Vue.http.post('auth/register', registerData)
            .then(response => response.json())
            .then(result => {
                commit('REGISTERED')
            });
    }
};

const mutations = {
    LOGGED(state) {
        state.logged = true;
    },
    REGISTERED(state) {
        state.registered = true;
    }
};

export default {
    state,
    getters,
    actions,
    mutations
}
