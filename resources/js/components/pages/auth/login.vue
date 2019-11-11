<template>
    <form class="login" @submit.prevent="login">
        <h1 class="login__header">
            Login
        </h1>

        <v-input
            v-model="form.email"
            :class="{ '-is-invalid': form.errors.has('email') }"
            type="email"
            name="email"
        />
        <has-error :form="form" field="email" />

        <v-input
            v-model="form.password"
            :class="{ '-is-invalid': form.errors.has('password') }"
            type="password"
            name="password"
        />
        <has-error :form="form" field="password" />

        <footer class="login__footer">
            <checkbox v-model="remember" name="remember">
                {{ $t('remember_me') }}
            </checkbox>

            <router-link :to="{ name: 'password.request' }" class="small ml-auto my-auto">
                {{ $t('forgot_password') }}
            </router-link>
        </footer>

        <v-button class="login__button" native-type="submit" :loading="form.busy" block>
            Submit
        </v-button>
    </form>
</template>

<script>
import { Form, HasError } from 'vform';
import { mapGetters } from 'vuex';
import VInput from '../../atoms/Input.vue';
import VButton from '../../atoms/Button.vue';
import Checkbox from '../../molecules/Checkbox.vue';

export default {
    middleware: 'guest',
    components: {
        Checkbox,
        HasError,
        VButton,
        VInput,
    },
    metaInfo() {
        return { title: this.$t('login') };
    },
    data: () => ({
        form: new Form({
            email: '',
            password: '',
        }),
        remember: false,
    }),
    computed: {
        ...mapGetters('auth', [
            'user',
        ]),
    },
    methods: {
        async login() {
            // Submit the form.
            const { data } = await this.form.post('/api/v1/login');

            // Save the token.
            this.$store.dispatch('auth/saveToken', {
                token: data.token,
                remember: this.remember,
            });

            // Fetch the user.
            await this.$store.dispatch('auth/fetchUser');

            // Redirect home.
            this.$router.push({
                name: 'channels.show',
                params: {
                    id: this.user.current_conversation_id || '',
                },
            });
        },
    },
};
</script>

<style lang="scss" scoped>
.login {
    width: 400px;
    margin: 4rem auto;
    padding: 2rem;

    &__header {
        text-align: center;
    }

    &__footer {
        display: flex;
        justify-content: space-between;
    }

    &__button {
        margin-top: 2rem;
    }
}
</style>
