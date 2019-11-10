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
import Sidebar from '../../molecules/Sidebar.vue';

export default {
    middleware: 'auth',
    components: {
        Sidebar,
    },
    mounted() {
        window.Echo.channel('glux_database_test')
            .listen('MessagePublished', () => {
                this.$nextTick(() => {
                    this.$refs.main.scrollTo({
                        top: this.$refs.chat.$el.offsetHeight,
                    });
                });
            });

        // TODO: Find a better way to do this.  Currently, it fires
        // before the CSS is fully loaded, causing it to not
        // scroll to the very bottom
        setTimeout(() => {
            this.$refs.main.scrollTo({
                top: this.$refs.chat.$el.offsetHeight,
            });
        }, 500);
    },
    methods: {
        handleScroll(e) {
            // TODO: Remove top gradient fade class on chat window when at top
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
