<template>
    <div class="form-field">
        <label :for="name" v-if="label" v-text="label" />
        <v-input
            :id="id"
            :name="name"
            :native-type="nativeType"
            :disabled="disabled"
        />
        <has-errors :form="form" :field="name" />
    </div>
</template>

<script>
import { HasErrors } from 'vform';
import VInput from './Input.vue';

export default {
    name: 'Field',
    components: {
        HasErrors,
        VInput,
    },
    props: {
        id: {
            type: String,
            default: '',
        },
        name: {
            type: String,
            default: '',
            required: true,
        },
        nativeType: {
            type: String,
            default: 'text',
        },
        label: {
            type: String,
            default: '',
        },
        form: {
            type: Object,
            default: () => ({}),
        },
    },
};
</script>
