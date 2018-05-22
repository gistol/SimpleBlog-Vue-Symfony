import Vue from 'vue';

const state = {
    items: [],
    item: {},
    number: 0,
    refresh: 0
};

const getters = {
    items: state => state.items,
    item: state => state.item,
    number: state => state.number,
    refresh: state => state.refresh,
};

const actions = {
    items({commit}, data) {
        Vue.http.get('post', {params:  data})
            .then(response => response.json())
            .then(result => {
                commit('NUMBER', result.number[1]);
                commit('ITEMS', result.posts);
            })
    },
    item({commit}, data) {
        Vue.http.get('post/' + data)
            .then(response => response.json())
            .then(result => {
                commit('ITEM', result);
            })
    }
};

const mutations = {
    ITEMS(state, items) {
        state.items = items;
    },
    ITEM(state, item) {
        state.item = item;
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
