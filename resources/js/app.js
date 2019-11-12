import Vue from 'vue';
import VueLuxon from 'vue-luxon';
import store from './store';
import router from './router';
import i18n from './plugins/i18n';
import App from './components/App.vue';

import 'simplebar/dist/simplebar.min.css';

import './plugins/echo';
import './plugins/directives';

Vue.config.productionTip = false;

Vue.use(VueLuxon);

/* eslint-disable no-new */
new Vue({
    i18n,
    store,
    router,
    ...App,
});
