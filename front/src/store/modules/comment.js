import Vue from 'vue';

const state = {
    refresh: 0
};

const getters = {
    refresh: state => state.refresh
};

const actions = {
    addComment({commit}, data) {
        Vue.http.post('comment/' + data.slug, {content: data.content})
            .then(response => response.json())
            .then(result => commit('REFRESH'));
    }
};

const mutations = {
    REFRESH(state) {
        state.refresh = ++state.refresh;
    }
};

export default {
    state,
    getters,
    actions,
    mutations
}
