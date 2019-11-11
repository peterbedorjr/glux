<template>
    <div class="chat">
        <div class="chat__sidebar">
            <sidebar />
        </div>
        <div class="chat__main" ref="main" @scroll="handleScroll">
            <router-view ref="chat" />
        </div>
    </div>
</template>

<script>
import { mapGetters } from 'vuex';
import Sidebar from '../molecules/Sidebar.vue';

export default {
    middleware: 'auth',
    components: {
        Sidebar,
    },
    computed: {
        ...mapGetters('channels', [
            'currentChannelId',
        ]),
    },
    watch: {
        $route(val) {
            // TODO: Put this in method to avoid duplicate code
            const channel = `glux_database_conversation.${val.params.id}`;

            this.$echo.channel(channel)
                .listen('MessagePublished', () => {
                    this.scrollToBottom();
                });
        },
    },
    mounted() {
        const channel = `glux_database_conversation.${this.$route.params.id}`;

        this.$echo.channel(channel)
            .listen('MessagePublished', () => {
                this.scrollToBottom();
            });

        // TODO: Find a better way to do this.  Currently, it fires
        // before the CSS is fully loaded, causing it to not
        // scroll to the very bottom
        setTimeout(() => {
            this.scrollToBottom();
        }, 500);
    },
    methods: {
        handleScroll(e) {
            // TODO: Remove top gradient fade class on chat window when at top
        },
        scrollToBottom() {
            // TODO: Find out why we need to nest $nextTicks
            this.$nextTick(() => {
                this.$nextTick(() => {
                    this.$refs.main.scrollTo({
                        top: this.$refs.chat.$el.offsetHeight,
                    });
                });
            });
        },
    },
    metaInfo() {
        return { title: this.$t('home') };
    },
};
</script>

<style lang="scss" scoped>
.chat {
    display: grid;
    height: 100%;
    grid-template-areas:
        "sidebar main";
    grid-template-columns: 20rem 1fr;

    &__sidebar {
        background-color: $primary;
        grid-area: sidebar;
    }

    &__main {
        grid-area: main;
        overflow: scroll;
    }
}
</style>
