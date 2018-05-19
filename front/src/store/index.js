import Vue from 'vue';
import Vuex from 'vuex';
import auth from './modules/auth';

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        dayIterator: 1
    },
    modules: {
        auth
    }
});
