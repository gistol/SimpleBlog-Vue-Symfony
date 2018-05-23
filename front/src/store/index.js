import Vue from 'vue';
import Vuex from 'vuex';

import auth from './modules/auth';
import post from './modules/post';
import comment from './modules/comment';

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        auth,
        post,
        comment
    }
});
