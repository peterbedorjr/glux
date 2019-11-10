<template>
    <div class="register">
        <div v-if="mustVerifyEmail" :title="$t('register')">
            <div class="alert alert-success" role="alert">
                {{ $t('verify_email_address') }}
            </div>
        </div>
        <div v-else :title="$t('register')">
            <form @submit.prevent="register" @keydown="form.onKeydown($event)">
                <!-- Name -->
                <div>
                    <label class="label" for="first_name">
                        {{ $t('first_name') }}
                    </label>
                    <v-input
                        v-model="form.first_name"
                        :class="{ 'is-invalid': form.errors.has('first_name') }"
                        name="first_name"
                    />
                    <has-error :form="form" field="first_name" />
                </div>

                <div>
                    <label class="label" for="last_name">
                        {{ $t('last_name') }}
                    </label>
                    <v-input
                        v-model="form.last_name"
                        :class="{ 'is-invalid': form.errors.has('last_name') }"
                        name="last_name"
                    />
                    <has-error :form="form" field="last_name" />
                </div>

                <div>
                    <label class="label" for="username">
                        {{ $t('username') }}
                    </label>
                    <v-input
                        v-model="form.username"
                        :class="{ 'is-invalid': form.errors.has('username') }"
                        name="username"
                    />
                    <has-error :form="form" field="username" />
                </div>

                <!-- Email -->
                <div>
                    <label class="label" for="email">
                        {{ $t('email') }}
                    </label>
                    <div>
                        <v-input
                            v-model="form.email"
                            :class="{ 'is-invalid': form.errors.has('email') }"
                            name="email"
                        />
                        <has-error :form="form" field="email" />
                    </div>
                </div>

                <!-- Password -->
                <div>
                    <label class="label" for="password">
                        {{ $t('password') }}
                    </label>
                    <div>
                        <v-input
                            v-model="form.password"
                            :class="{ 'is-invalid': form.errors.has('password') }"
                            native-type="password"
                            name="password"
                        />
                        <has-error :form="form" field="password" />
                    </div>
                </div>

                <!-- Password Confirmation -->
                <div>
                    <label class="label" for="confirm_password">
                        {{ $t('confirm_password') }}
                    </label>
                    <div>
                        <v-input
                            v-model="form.confirm_password"
                            :class="{ 'is-invalid': form.errors.has('confirm_password') }"
                            native-type="confirm_password"
                            name="confirm_password"
                        />
                        <has-error :form="form" field="confirm_password" />
                    </div>
                </div>

                <v-button :loading="form.busy">
                    {{ $t('register') }}
                </v-button>
            </form>
        </div>
    </div>
</template>

<script>
import { Form, HasError } from 'vform';
import VInput from '../../atoms/Input.vue';
import VButton from '../../atoms/Button.vue';

export default {
    middleware: 'guest',
    components: {
        VInput,
        VButton,
        HasError,
    },
    metaInfo() {
        return { title: this.$t('register') };
    },
    data: () => ({
        form: new Form({
            name: '',
            email: '',
            password: '',
            password_confirmation: '',
        }),
        mustVerifyEmail: false,
    }),
    methods: {
        async register() {
            // Register the user.
            const { data } = await this.form.post('/api/v1/register');

            // Must verify email fist.
            if (data.status) {
                this.mustVerifyEmail = true;
            } else {
                // Log in the user.
                const { data: { token } } = await this.form.post('/api/v1/login');

                // Save the token.
                this.$store.dispatch('auth/saveToken', { token });

                // Update the user.
                await this.$store.dispatch('auth/updateUser', { user: data });

                // Redirect home.
                this.$router.push({ name: 'channels' });
            }
        },
    },
};
</script>

<style lang="scss" scoped>
.register {
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
