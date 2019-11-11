import Echo from 'laravel-echo';
import Vue from 'vue';

window.io = require('socket.io-client');

// Have this in case you stop running your laravel echo server
if (typeof io !== 'undefined') {
    window.Echo = new Echo({
        broadcaster: 'socket.io',
        host: `https://${window.location.hostname}:6001`,
    });

    Vue.prototype.$echo = window.Echo;
}
