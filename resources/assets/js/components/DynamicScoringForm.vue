<template>
    <component :is="submit.order.package.name" v-bind:submit="submit" v-if="submit != null && submit.order.package != null"></component>
</template>

<script>
    import HIV123 from './scoring/HIV-123/index';

    export default {
        name: "DynamicScoringForm",
        props: ['pmePackage', 'submit'],
        components: {
            'HIV-123': HIV123,
        },
    }
</script>

<style scoped>

</style>