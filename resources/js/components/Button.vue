<template>
    <button
        :type="nativeType"
        :disabled="loading"
        :class="classes"
        class="button"
        @click="$emit('click', $event)"
    >
        <slot />
    </button>
</template>

<script>
export default {
    name: 'VButton',
    props: {
        type: {
            type: String,
            default: 'primary',
        },
        nativeType: {
            type: String,
            default: 'submit',
        },
        loading: {
            type: Boolean,
            default: false,
        },
        block: {
            type: Boolean,
            default: false,
        },
        large: {
            type: Boolean,
            default: false,
        },
        icon: {
            type: Boolean,
            default: false,
        },
    },
    computed: {
        classes() {
            const classes = [];

            classes.push({
                '-loading': this.loading,
            });

            if (this.type) {
                classes.push(`-${this.type}`);
            }

            if (this.icon) {
                classes.push('-icon');
            }
            //
            // if (this.block) {
            //     classes['-block'] = true;
            // }
            //

            return classes;
        },
    },
};
</script>

<style lang="scss" scoped>
.button {
    &.-icon {
        padding: 0;
        line-height: 0;
        background-color: transparent;
    }
}
</style>
