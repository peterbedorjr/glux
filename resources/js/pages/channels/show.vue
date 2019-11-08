<template>
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
</template>

<script>
import axios from 'axios';
import { DateTime } from 'luxon';

export default {
    middleware: 'auth',
    async beforeRouteEnter(to, from, next) {
        const { data } = await axios.get(`/api/v1/channels/${to.params.id}/messages`);
        console.log(DateTime.fromISO(data.data[0].created_at_iso));
        next((vm) => {
            vm.messages = data.data;
        });
    },
    data: () => ({
        messages: [],
    }),
};
</script>

<style lang="scss" scoped>
.messages {
    list-style-type: none;
    padding: 2rem;
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
</style>
