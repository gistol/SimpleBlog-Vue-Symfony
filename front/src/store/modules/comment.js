import Vue from 'vue';

const state = {
    refreshComment: 0
};

const getters = {
    refreshComment: state => state.refreshComment
};

const actions = {
    addComment({commit}, data) {
        Vue.http.post('comment/' + data.slug, {content: data.content})
            .then(response => response.json())
            .then(result => commit('REFRESHCOMMENT'));
    }
};

const mutations = {
    REFRESHCOMMENT(state) {
        state.refreshComment = ++state.refreshComment;
    }
};

export default {
    state,
    getters,
    actions,
    mutations
}
