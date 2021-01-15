<template>
    <footer class="ui inverted vertical footer segment">
        <div class="ui center aligned container">
            <div class="ui horizontal inverted small divided link list">
                <span class="item" id="footer-text">Copyright © 2019 <a :href="homepage" target="_blank">{{ copyrightHolder }}</a>. Hak cipta dilindungi undang-undang.</span>
            </div>
        </div>
    </footer>
</template>

<script>
    export default {
        name: "Footer",
        data() {
            return {
                homepage: window.config.homepage,
                copyrightHolder: window.config.copyrightHolder,
            }
        }
    }
</script>

<style scoped>

</style>