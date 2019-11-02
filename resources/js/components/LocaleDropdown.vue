<template>
    <div class="dropdown">
        <a
            class="dropdown__toggle"
            href="#"
            role="button"
            data-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false"
            @click="open = ! open"
        >
            {{ locales[locale] }}
        </a>
        <ul :class="['dropdown-menu', { '-is-open': open }]">
            <li
                v-for="(value, key) in locales"
                :key="key"
                class="dropdown-menu__item"
                @click.prevent="setLocale(key)"
            >
                {{ value }}
            </li>
        </ul>
    </div>
</template>

<script>
import { mapGetters } from 'vuex';
import { loadMessages } from '../plugins/i18n';

export default {
    computed: mapGetters({
        locale: 'lang/locale',
        locales: 'lang/locales',
    }),
    data: () => ({
        open: true,
    }),
    methods: {
        setLocale(locale) {
            if (this.$i18n.locale !== locale) {
                loadMessages(locale);

                this.$store.dispatch('lang/setLocale', { locale })
            }
        },
    },
};
</script>

<style lang="scss" scoped>
.dropdown {
    &__toggle {
        color: $white;
    }

    &__item {

    }
}

.dropdown-menu {
    display: none;
    list-style-type: none;
    margin: 0;
    padding: 1rem;
    background: darken($primary, 5%);

    &.-is-open {
        display: block;
    }

    &__item {
        color: $white;
        cursor: pointer;
    }
}
</style>
