<template>
    <div class="ui active inverted dimmer">
        <div class="ui text loader">{{ loadingText }}</div>
    </div>
</template>

<script>
    export default {
        name: "Loader",
        props: ['loadingText'],
    }
</script>

<style scoped>

</style>