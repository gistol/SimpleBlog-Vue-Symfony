import jwt from 'jsonwebtoken';
import publicKey from './../../jwt/public';

const state = {
    logged: false
};

const getters = {
    logged: state => state.logged
};

const actions = {
    login({commit}, loginData) {
        axios.post('login_check', loginData)
            .then(result => {
                console.log(result);
                jwt.verify(result.data.token, publicKey, error => {
                    if(!error) {
                        localStorage.setItem('token', result.data.token);
                        commit('LOGGED');
                    }
                })
            })
        ;
    }
};

const mutations = {
    LOGGED(state) {
        state.logged = true;
    }
};

export default {
    state,
    getters,
    actions,
    mutations
}
