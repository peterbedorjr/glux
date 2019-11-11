import Cookies from 'js-cookie';
import { SET_LOCALE } from '../mutation-types';

const { locale, locales } = window.config;

// state
export const state = {
    locale: Cookies.get('locale') || locale,
    locales,
};

// getters
export const getters = {
    locale: s => s.locale,
    locales: s => s.locales,
};

// mutations
export const mutations = {
    [SET_LOCALE](s, { locale }) {
        s.locale = locale;
    },
};

// actions
export const actions = {
    /* eslint-disable-next-line */
    setLocale({ commit }, { locale }) {
        commit(SET_LOCALE, { locale });

        Cookies.set('locale', locale, { expires: 365 });
    },
};
