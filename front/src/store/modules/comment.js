import Vue from 'vue';

const state = {
    comments: []
};

const getters = {
    comments: state => state.comments,
};

const actions = {
    comments({commit}, data) {
        Vue.http.get('comment/' + data)
            .then(response => response.json())
            .then(result => {
                commit('COMMENTS', result.comments);
            })
    }
};

const mutations = {
    COMMENTS(state, comments) {
        state.comments = comments;
    }
};

export default {
    state,
    getters,
    actions,
    mutations
}
