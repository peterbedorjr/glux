import Echo from 'laravel-echo';

window.io = require('socket.io-client');

// window.Pusher = require('pusher-js');
// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: '4b16148f41bba687fc63',
//     cluster: 'us2',
//     encrypted: true,
// });
//
// window.Echo.channel('test')
//     .listen('MessagePublished', (e) => {
//         console.log(e);
//     });

// Have this in case you stop running your laravel echo server
if (typeof io !== 'undefined') {
    window.Echo = new Echo({
        broadcaster: 'socket.io',
        host: `https://${window.location.hostname}:6001`,
    });
}
