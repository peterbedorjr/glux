<template>
    <simplebar class="chat-window">
        <ul class="messages">
            <li
                v-for="message in messages"
                :key="message.id"
                class="message"
            >
                <div class="message__avatar">
                    <img
                        :src="message.user.avatar"
                        :alt="message.user.username"
                    />
                </div>
                <div class="message__main">
                    <div class="message__user">
                        {{ message.user.username }}
                        <span class="message__time">
                            {{ message.created_at_iso|luxon:format('t') }}
                        </span>
                    </div>
                    <div class="message__content" v-markdown="message.content" />
                </div>
            </li>
        </ul>
        <div class="chat-input-wrap">
            <textarea
                class="chat-input"
                v-model="message"
                @keydown.enter.exact.prevent="submitMessage"
            />
        </div>
    </simplebar>
</template>

<script>
import axios from 'axios';
import Simplebar from 'simplebar-vue';

export default {
    middleware: 'auth',
    components: {
        Simplebar,
    },
    async beforeRouteUpdate(to, from, next) {
        const channelId = to.params.id;
        const { data } = await axios.get(`/api/v1/channels/${channelId}/messages`);

        this.messages = data.data.reverse();
        this.channelId = channelId;

        const channel = `glux_database_conversation.${channelId}`;

        // Leave the previous channel to avoid duplicate events
        // TODO: Look into presence channels so we can send updates for
        // all channels to users
        this.$echo.leaveChannel(`glux_database_conversation.${from.params.id}`);

        this.$echo.channel(channel)
            .listen('MessagePublished', (e) => {
                this.messages.push(e.message);
            });

        next();
    },
    async beforeRouteEnter(to, from, next) {
        const channelId = to.params.id;
        const { data } = await axios.get(`/api/v1/channels/${channelId}/messages`);

        next((vm) => {
            vm.messages = data.data.reverse();
            vm.channelId = channelId;

            const channel = `glux_database_conversation.${channelId}`;

            vm.$echo.leaveChannel(`glux_database_conversation.${from.params.id}`);

            vm.$echo.channel(channel)
                .listen('MessagePublished', (e) => {
                    vm.messages.push(e.message);
                });
        });
    },
    data: () => ({
        messages: [],
        channelId: null,
        message: '',
    }),
    methods: {
        async submitMessage(e) {
            if (this.message) {
                try {
                    await axios.post(`/api/v1/channels/${this.channelId}/messages`, {
                        message: this.message,
                    });

                    this.message = '';
                } catch (e) {
                    // TODO: Error handling
                }
            }
        },
    },
};
</script>

<style lang="scss" scoped>
.messages {
    list-style-type: none;
    padding: 2rem;
    position: relative;
    margin-bottom: 6rem;

    /*&::before {*/
    /*    content: '';*/
    /*    display: block;*/
    /*    width: 100%;*/
    /*    height: 8rem;*/
    /*    background: rgb(6,36,0);*/
    /*    background: linear-gradient(0deg, rgba(6,36,0,0) 0%, rgba(255,255,255,1) 100%);*/
    /*    position: fixed;*/
    /*    top: 0;*/
    /*    left: 20rem;*/
    /*    right: 0;*/
    /*}*/

    /*&.-at-top {*/
    /*    &::before {*/
    /*        display: none;*/
    /*    }*/
    /*}*/
}

.message {
    display: flex;
    margin-bottom: 2rem;
    word-wrap: break-word;

    &__avatar {
        flex: 0 0 5rem;
        margin-right: 1.5rem;
    }

    &__user {
        font-weight: $boldFontWeight;
        line-height: 1;
    }

    &__time {
        font-weight: $normalFontWeight;
        color: $gray;
        font-size: 1.2rem;
        margin-left: .5rem;
    }
}

.chat-input-wrap {
    position: fixed;
    bottom: 0;
    left: 20rem;
    right: 0;
}

.chat-input {
    width: 100%;
    padding: 1.5rem;
    font-family: $baseFont;
    resize: none;
}
</style>
