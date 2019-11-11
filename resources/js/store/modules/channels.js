import axios from 'axios';
import { SET_CHANNELS, SET_CURRENT_CHANNEL_ID } from '../mutation-types';

// state
export const state = {
    channels: [],
    currentChannelId: null,
};

// getters
export const getters = {
    channels: s => s.channels,
    currentChannelId: s => parseInt(s.currentChannelId),
};

// mutations
export const mutations = {
    [SET_CHANNELS](s, { channels }) {
        s.channels = channels;
    },
    [SET_CURRENT_CHANNEL_ID](s, { id }) {
        s.currentChannelId = id;
    },
};

// actions
export const actions = {
    /**
     * Fetch a users channels
     *
     * @param commit
     * @returns {Promise<void>}
     */
    async fetchChannels({ commit }) {
        try {
            const { data: channels } = await axios.get('/api/v1/user/channels');

            commit(SET_CHANNELS, { channels });
        } catch (e) {
            // TODO: Error handling
        }
    },

    /**
     * Set the current channel id
     *
     * @param commit
     * @param id
     */
    setCurrentChannelId({ commit }, { id }) {
        commit(SET_CURRENT_CHANNEL_ID, { id });
    },
};
