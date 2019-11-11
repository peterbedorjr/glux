import axios from 'axios';
import Cookies from 'js-cookie';
import {
    SAVE_TOKEN,
    LOGOUT,
    UPDATE_USER,
    FETCH_USER_FAILURE,
    FETCH_USER_SUCCESS,
} from '../mutation-types';

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
    [SAVE_TOKEN](s, { token, remember }) {
        s.token = token;
        Cookies.set('token', token, { expires: remember ? 365 : null });
    },

    [FETCH_USER_SUCCESS](s, { user }) {
        s.user = user;
    },

    [FETCH_USER_FAILURE](s) {
        s.token = null;
        Cookies.remove('token');
    },

    [LOGOUT](s) {
        s.user = null;
        s.token = null;

        Cookies.remove('token');
    },

    [UPDATE_USER](s, { user }) {
        s.user = user;
    },
};

// actions
export const actions = {
    saveToken({ commit }, payload) {
        commit(SAVE_TOKEN, payload);
    },
    async fetchUser({ commit }) {
        try {
            const { data } = await axios.get('/api/v1/user');

            commit(FETCH_USER_SUCCESS, { user: data });
        } catch (e) {
            commit(FETCH_USER_FAILURE);
        }
    },
    updateUser({ commit }, payload) {
        commit(UPDATE_USER, payload);
    },

    async logout({ commit }) {
        try {
            await axios.post('/api/v1/logout');
        } catch (e) {
            //
        }

        commit(LOGOUT);
    },

    async fetchOauthUrl(ctx, { provider }) {
        const { data } = await axios.post(`/api/v1/oauth/${provider}`);

        return data.url;
    },
};
