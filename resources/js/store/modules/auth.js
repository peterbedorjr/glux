import axios from 'axios';
import Cookies from 'js-cookie';
import * as types from '../mutation-types';

// state
export const state = {
    user: null,
    token: Cookies.get('token'),
};

// getters
export const getters = {
    user: s => s.user,
    token: s => s.token,
    check: s => s.user !== null,
};

// mutations
export const mutations = {
    [types.SAVE_TOKEN](s, { token, remember }) {
        s.token = token;
        Cookies.set('token', token, { expires: remember ? 365 : null });
    },

    [types.FETCH_USER_SUCCESS](s, { user }) {
        s.user = user;
    },

    [types.FETCH_USER_FAILURE](s) {
        s.token = null;
        Cookies.remove('token');
    },

    [types.LOGOUT](s) {
        s.user = null;
        s.token = null;

        Cookies.remove('token');
    },

    [types.UPDATE_USER](s, { user }) {
        s.user = user;
    },
};

// actions
export const actions = {
    saveToken({ commit }, payload) {
        commit(types.SAVE_TOKEN, payload);
    },

    async fetchUser({ commit }) {
        try {
            const { data } = await axios.get('/api/user');

            commit(types.FETCH_USER_SUCCESS, { user: data });
        } catch (e) {
            commit(types.FETCH_USER_FAILURE);
        }
    },

    updateUser({ commit }, payload) {
        commit(types.UPDATE_USER, payload);
    },

    async logout({ commit }) {
        try {
            await axios.post('/api/logout');
        } catch (e) { }

        commit(types.LOGOUT);
    },

    async fetchOauthUrl(ctx, { provider }) {
        const { data } = await axios.post(`/api/oauth/${provider}`);

        return data.url;
    },
};
