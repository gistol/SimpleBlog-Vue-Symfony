import Vue from 'vue';
import jwt from 'jsonwebtoken';
import publicKey from './../../jwt/public';

const types = {
    LOGGED: 'LOGGED',
    LOGOUT: 'LOGOUT'
};

const state = {
    logged: localStorage.getItem('token'),
    roles: localStorage.getItem('roles'),
    registered: false
};

const getters = {
    logged: state => state.logged,
    roles: state => state.roles,
    registered: state =>  state.registered
};

const actions = {
    login({commit}, loginData) {
        Vue.http.post('auth/login', loginData)
            .then(response => response.json())
            .then(result => {
                jwt.verify(result.token, publicKey, error => {
                    if(!error) {
                        let jwtData = result.token.split('.')[1];
                        let decodedJwtJsonData = window.atob(jwtData);
                        localStorage.setItem('token', result.token);
                        localStorage.setItem('roles', JSON.parse(decodedJwtJsonData).roles);

                        commit('LOGGED');
                    }
                })
            });
    },
    logout({commit}) {
        localStorage.removeItem('token');
        localStorage.removeItem('roles');
        commit('LOGOUT');
    },
    register({commit}, registerData) {
        Vue.http.post('auth/register', registerData)
            .then(response => response.json())
            .then(result => {
                commit('REGISTERED');
            });
    }
};

const mutations = {
    [types.LOGGED](state) {
        state.logged = true;
    },
    [types.LOGOUT](state) {
        state.logged = false
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
