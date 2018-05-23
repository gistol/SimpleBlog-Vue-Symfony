import Vue from 'vue';

const state = {
    posts: [],
    post: {},
    number: 0,
    refresh: 0
};

const getters = {
    posts: state => state.posts,
    post: state => state.post,
    number: state => state.number,
    refresh: state => state.refresh,
};

const actions = {
    posts({commit}, data) {
        Vue.http.get('post', {params:  data})
            .then(response => response.json())
            .then(result => {
                commit('NUMBER', result.number[1]);
                commit('POSTS', result.posts);
            })
    },
    post({commit}, data) {
        Vue.http.get('post/' + data)
            .then(response => response.json())
            .then(result => {
                commit('POST', JSON.parse(result));
            })
    }
};

const mutations = {
    POSTS(state, posts) {
        state.posts = posts;
    },
    POST(state, post) {
        state.post = post;
    },
    NUMBER(state, number) {
        state.number = number;
    },
    REFRESH(state) {
        state.refresh = ++state.refresh
    }
};

export default {
    state,
    getters,
    actions,
    mutations
}
