import Vue from 'vue';
import moment from 'moment'

const state = {
    posts: [],
    post: {},
    number: 0,
    refreshPost: 0
};

const getters = {
    posts: state => state.posts,
    post: state => state.post,
    number: state => state.number,
    refreshPost: state => state.refreshPost,
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
                const post = JSON.parse(result);
                post.comments.forEach(comment => comment.published_at = moment(comment.published_at).fromNow())
                commit('POST', post);
            })
    },
    createPost({commit}, data) {
        Vue.http.post('post', data)
            .then(response => response.json())
            .then(result => commit('REFRESHPOST'))
    },
    updatePost({commit}, data) {
        Vue.http.put('post/' + data.slug, data)
            .then(response => response.json())
            .then(result => commit('REFRESHPOST'))
    },
    deletePost({commit}, data) {
        Vue.http.delete('post/' + data)
            .then(response => response.json())
            .then(result => commit('REFRESHPOST'))
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
    REFRESHPOST(state) {
        state.refreshPost = ++state.refreshPost
    }
};

export default {
    state,
    getters,
    actions,
    mutations
}
