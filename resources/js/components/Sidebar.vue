<template>
    <div class="sidebar">
        <header class="sidebar__header">
            <h1 class="sidebar__logo">Glux</h1>
        </header>
        <ul class="conversations">
            <li>
                <span class="conversations__section-heading">
                    Channels
                </span>
                <ul class="conversations__section">
                    <li
                        v-for="channel in channels"
                        :key="channel.id"
                        :class="{ '-is-selected': channel.id == selectedChannelId }"
                        class="conversations__conversation"
                    >
                        # {{ channel.name }}
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    async mounted() {
        // TODO: Move these api calls into their own file
        // TODO: Add error handling and load state
        const { data: channels } = await axios.get('/api/v1/user/channels');

        this.channels = channels;
        this.selectedChannelId = this.$route.params.id;
    },
    data: () => ({
        channels: [],
        selectedChannelId: null,
    }),
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
