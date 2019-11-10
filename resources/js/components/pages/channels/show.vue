<template>
    <div class="chat-window">
        <ul class="messages">
            <li
                class="message"
                v-for="message in messages"
                :key="message.id"
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
                    <div class="message__content">
                        {{ message.content }}
                    </div>
                </div>
            </li>
        </ul>
        <div class="chat-input-wrap">
            <textarea v-model="message" class="chat-input" @keydown.enter.prevent="submitMessage"></textarea>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    middleware: 'auth',
    async beforeRouteEnter(to, from, next) {
        const { data } = await axios.get(`/api/v1/channels/${to.params.id}/messages`);

        next((vm) => {
            vm.messages = data.data.reverse();
            vm.channelId = to.params.id;
        });
    },
    data: () => ({
        messages: [],
        channelId: null,
        message: '',
    }),
    mounted() {
        window.Echo.channel('glux_database_test')
            .listen('MessagePublished', (e) => {
                this.messages.push(e.message);
            });
    },
    methods: {
        async submitMessage() {
            if (this.message) {
                const { data } = await axios.post(`/api/v1/channels/${this.channelId}/messages`, {
                    message: this.message,
                });

                this.message = '';
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

    &::before {
        content: '';
        display: block;
        width: 100%;
        height: 8rem;
        background: rgb(6,36,0);
        background: linear-gradient(0deg, rgba(6,36,0,0) 0%, rgba(255,255,255,1) 100%);
        position: fixed;
        top: 0;
        left: 20rem;
        right: 0;
    }

    &.-at-top {
        &::before {
            display: none;
        }
    }
}

.message {
    display: flex;
    margin-bottom: 2rem;

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
