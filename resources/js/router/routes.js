function component(path) {
    return () => import(/* webpackChunkName: '' */ `../components/${path}`)
        .then(m => m.default || m);
}

function page(path) {
    return component(`pages/${path}`);
}

export default [
    { path: '/', name: 'welcome', component: page('home.vue') },

    { path: '/login', name: 'login', component: page('auth/login.vue') },
    { path: '/register', name: 'register', component: page('auth/register.vue') },

    {
        path: '/channels',
        name: 'channels',
        component: page('channels/index.vue'),
        children: [
            { path: ':id', name: 'channel.show', component: page('channels/show.vue') },
        ],
    },

    { path: '*', component: page('errors/404.vue') },
];
