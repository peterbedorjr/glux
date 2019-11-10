<template>
    <input
        :id="id || name"
        :name="name"
        :type="nativeType"
        :disabled="disabled"
        :class="classes"
        class="input"
        @input="$emit('input', $event.target.value)"
    />
</template>

<script>
export default {
    name: 'VInput',
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
        disabled: {
            type: Boolean,
            default: false,
        },
    },
    computed: {
        classes() {
            const classes = [];

            return classes;
        },
    },
};
</script>

<style lang="scss" scoped>
    .input {
        &.-is-invalid {
            margin-bottom: 0;
        }
    }
</style>
