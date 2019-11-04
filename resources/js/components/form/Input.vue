<template>
    <input
        :id="id"
        :name="name"
        :type="nativeType"
        :disabled="disabled"
        :class="classes"
        class="input"
        @input="$emit('input', $event.value)"
    />
</template>

<script>
export default {
    name: 'VButton',
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
    mounted() {
        // Set default id if not provided
        if (! this.id) {
            this.id = this.name;
        }
    },
};
</script>

<style lang="scss" scoped>

</style>
