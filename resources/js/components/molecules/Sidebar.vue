<template>
    <div class="sidebar">
        <header class="sidebar__header">
            <h1 class="sidebar__logo">
                Glux
            </h1>
        </header>
        <ul class="conversations">
            <li>
                <span class="conversations__section-heading">
                    Channels
                </span>
                <ul class="conversations__section">
                    <router-link
                        v-for="channel in channels"
                        :key="channel.id"
                        :to="{ name: 'channels.show', params: { id: channel.id } }"
                        tag="li"
                        :class="{ '-is-selected': channel.id == currentChannelId }"
                        class="conversations__conversation"
                    >
                        # {{ channel.name }}
                    </router-link>
                </ul>
            </li>
        </ul>
        <v-button @click="logout">
            {{ $t('logout') }}
        </v-button>
    </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import VButton from '../atoms/Button';

export default {
    components: {VButton},
    computed: {
        ...mapGetters('channels', [
            'channels',
            'currentChannelId',
        ]),
    },
    watch: {
        $route(to) {
            this.setCurrentChannelId({
                id: to.params.id,
            });
        },
    },
    async mounted() {
        await this.fetchChannels();

        this.setCurrentChannelId({
            id: this.$route.params.id,
        });
    },
    methods: {
        ...mapActions('channels', [
            'fetchChannels',
            'setCurrentChannelId',
        ]),
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
.sidebar {
    &__logo {
        color: $white;
        margin-bottom: 0;
        padding: 1rem;
    }

    &__header {
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: darken($primary, 5%);
    }
}
.conversations {
    list-style-type: none;
    margin-top: 2rem;

    &__section-heading {
        color: $white;
        font-weight: $boldFontWeight;
    }

    &__section {
        list-style-type: none;
        margin: 0;
    }

    &__section-heading,
    &__conversation {
        padding-left: 2rem;
        padding-right: 2rem;
    }

    &__conversation {
        color: $white;
        cursor: pointer;

        &.-is-selected {
            background-color: darken($primary, 5%);

            &:hover {
                background-color: darken($primary, 7%);
            }
        }

        &:hover {
            background-color: darken($primary, 5%);
        }
    }
}
</style>
