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
        component: page('home'),
        children: [
            { path: ':id', name: 'channels.show', component: page('channels/show.vue') },
        ],
    },

    { path: '*', component: page('errors/404.vue') },
];
