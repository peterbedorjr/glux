<template>
    <div class="login">
        <v-input
            v-model="form.email"
            :class="{ '-is-invalid': form.errors.has('email') }"
            type="email"
            name="email"
        />
        <has-error :form="form" field="email" />

        <v-input
            v-model="form.email"
            :class="{ '-is-invalid': form.errors.has('password') }"
            type="password"
            name="password"
        />
        <has-error :form="form" field="password" />
    </div>
<!--    <div class="row">-->
<!--        <div class="col-lg-8 m-auto">-->
<!--            <card :title="$t('login')">-->
<!--                <form @submit.prevent="login" @keydown="form.onKeydown($event)">-->
<!--                    &lt;!&ndash; Email &ndash;&gt;-->
<!--                    <div class="form-group row">-->
<!--                        <label class="col-md-3 col-form-label text-md-right">{{ $t('email') }}</label>-->
<!--                        <div class="col-md-7">-->
<!--                            <input v-model="form.email" :class="{ 'is-invalid': form.errors.has('email') }" class="form-control" type="email" name="email">-->
<!--                            <has-error :form="form" field="email" />-->
<!--                        </div>-->
<!--                    </div>-->

<!--                    &lt;!&ndash; Password &ndash;&gt;-->
<!--                    <div class="form-group row">-->
<!--                        <label class="col-md-3 col-form-label text-md-right">{{ $t('password') }}</label>-->
<!--                        <div class="col-md-7">-->
<!--                            <input v-model="form.password" :class="{ 'is-invalid': form.errors.has('password') }" class="form-control" type="password" name="password">-->
<!--                            <has-error :form="form" field="password" />-->
<!--                        </div>-->
<!--                    </div>-->

<!--                    &lt;!&ndash; Remember Me &ndash;&gt;-->
<!--                    <div class="form-group row">-->
<!--                        <div class="col-md-3" />-->
<!--                        <div class="col-md-7 d-flex">-->
<!--                            <checkbox v-model="remember" name="remember">-->
<!--                                {{ $t('remember_me') }}-->
<!--                            </checkbox>-->

<!--                            <router-link :to="{ name: 'password.request' }" class="small ml-auto my-auto">-->
<!--                                {{ $t('forgot_password') }}-->
<!--                            </router-link>-->
<!--                        </div>-->
<!--                    </div>-->

<!--                    <div class="form-group row">-->
<!--                        <div class="col-md-7 offset-md-3 d-flex">-->
<!--                            &lt;!&ndash; Submit Button &ndash;&gt;-->
<!--                            <v-button :loading="form.busy">-->
<!--                                {{ $t('login') }}-->
<!--                            </v-button>-->

<!--                            &lt;!&ndash; GitHub Login Button &ndash;&gt;-->
<!--                            <login-with-github />-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </form>-->
<!--            </card>-->
<!--        </div>-->
<!--    </div>-->
</template>

<script>
import Form from 'vform';
import LoginWithGithub from '../../components/LoginWithGithub.vue';
import VInput from '../../components/form/Input.vue';
import InputField from '../../components/form/InputField.vue';

export default {
    middleware: 'guest',
    components: {
        LoginWithGithub,
        VInput,
        InputField,
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
    methods: {
        async login() {
            // Submit the form.
            const { data } = await this.form.post('/api/login');

            // Save the token.
            this.$store.dispatch('auth/saveToken', {
                token: data.token,
                remember: this.remember,
            });

            // Fetch the user.
            await this.$store.dispatch('auth/fetchUser');

            // Redirect home.
            this.$router.push({ name: 'home' });
        },
    },
};
</script>
