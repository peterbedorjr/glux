<template>
    <nav class="navbar">
        <div class="container">
            <div class="navbar__top">
                <router-link :to="{ name: user ? 'home' : 'welcome' }">
                    <h1 class="navbar__brand">{{ appName }}</h1>
                </router-link>

                <v-button
                    native-type="button"
                    icon
                    aria-controls="navbarToggler"
                    :aria-expanded="navOpen"
                    class="navbar-toggle"
                    @click="navOpen = ! navOpen"
                >
                    <menu-icon size="1.5x" />
                </v-button>
                <div id="navbarToggler" :class="['nav', { '-is-open': navOpen }]">
                    <ul class="nav-menu">
                        <locale-dropdown />
                        <li class="nav-menu__item">
                            <a class="nav-menu__link" href="#">Link</a>
                        </li>
                    </ul>

                    <ul class="nav-menu">
                        <!-- Authenticated -->
                        <li v-if="user" class="nav-item dropdown">
                            <a class="nav-menu__link dropdown-toggle text-dark"
                               href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                            >
                                <img :src="user.photo_url" class="rounded-circle profile-photo mr-1">
                                {{ user.name }}
                            </a>
                            <div class="dropdown-menu">
                                <router-link :to="{ name: 'settings.profile' }" class="dropdown-item pl-3">
                                    <fa icon="cog" fixed-width />
                                    {{ $t('settings') }}
                                </router-link>

                                <div class="dropdown-divider" />
                                <a href="#" class="dropdown-item pl-3" @click.prevent="logout">
                                    <fa icon="sign-out-alt" fixed-width />
                                    {{ $t('logout') }}
                                </a>
                            </div>
                        </li>
                        <!-- Guest -->
                        <template v-else>
                            <li class="nav-menu__item">
                                <router-link :to="{ name: 'login' }" class="nav-menu__link" active-class="active">
                                    {{ $t('login') }}
                                </router-link>
                            </li>
                            <li class="nav-menu__item">
                                <router-link :to="{ name: 'register' }" class="nav-menu__link" active-class="active">
                                    {{ $t('register') }}
                                </router-link>
                            </li>
                        </template>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</template>

<script>
import { MenuIcon } from 'vue-feather-icons';
import { mapGetters } from 'vuex';
import LocaleDropdown from './LocaleDropdown.vue';
import VButton from './Button.vue';

export default {
    components: {
        LocaleDropdown,
        VButton,
        MenuIcon,
    },

    data: () => ({
        appName: window.config.appName,
        navOpen: true,
        // navOpen: false,
    }),

    computed: mapGetters({
        user: 'auth/user',
    }),

    methods: {
        async logout() {
            // Log out the user.
            await this.$store.dispatch('auth/logout');

            // Redirect to login.
            this.$router.push({ name: 'login' });
        },
    },
};
</script>

<style lang="scss" scoped>
.navbar {
    background-color: $primary;
    padding-bottom: 1rem;
    padding-top: 1rem;
    height: 5.4rem;

    &__brand {
        margin-bottom: 0;
        color: $white;
        font-weight: $normalFontWeight;
    }

    &__top {
        align-items: center;
        display: flex;
        justify-content: space-between;
    }
}

.nav {
    position: fixed;
    height: 100%;
    background-color: $primary;
    width: 70%;
    right: 0;
    top: 5.4rem;
    transform: translateX(100%);
    transition: transform .3s ease-in-out;
    padding: 2rem;

    &.-is-open {
        transform: translateX(0);
    }
}

.nav-menu {
    &__link {
        color: $white;
    }
}

@include desktop {
    .nav {
        position: initial;
        transform: initial;
        height: initial;
        width: initial;
        padding: 0;
        display: flex;
    }

    .navbar-toggle {
        display: none;
    }
}
</style>
