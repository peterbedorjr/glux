<template>
    <div class="chat">
        <div class="chat__sidebar">
            <sidebar />
        </div>
        <div class="chat__main">
            <router-view />
        </div>
    </div>
</template>

<script>
import Sidebar from '../components/Sidebar.vue';

export default {
    middleware: 'auth',
    components: {
        Sidebar,
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
