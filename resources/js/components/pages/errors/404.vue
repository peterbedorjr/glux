<template>
    <div>
        <h3>{{ $t('page_not_found') }}</h3>

        <div>
            <router-link :to="{ name: 'home' }">
                {{ $t('go_home') }}
            </router-link>
        </div>
    </div>
</template>

<script>
export default {
    name: 'NotFound',
};
</script>
