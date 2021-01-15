<template>
    <div class="site">
        <top-nav></top-nav>
        <main class="site-content">
            <main class="ui content" id="content-container">
                <div class="pme-dashboard">
                    <div class="pme-dashboard-menu">
                        <pme-menu v-bind:selected-menu="selectedMenu"></pme-menu>
                    </div>
                    <div class="pme-dashboard-content">
                        <slot></slot>
                    </div>
                </div>
            </main>
        </main>
        <pme-footer></pme-footer>
    </div>
</template>

<script>
    import Footer from '../components/Footer';
    import InstallationTopNav from "../components/InstallationTopNav";
    import InstallationMenu from "../components/InstallationMenu";

    export default {
        props: ['selectedMenu'],
        name: "InstallationLayout",
        components: {
            'top-nav': InstallationTopNav,
            'pme-footer': Footer,
            'pme-menu': InstallationMenu,
        },
        mounted() {
            console.log(window.user);
        },
    }
</script>

<style scoped>
    .site {
        display: flex;
        min-height: 100vh;
        flex-direction: column;
    }

    .site-content {
        flex: 1;
    }

    .pme-dashboard {
        display: grid;
        grid-template-columns: 1fr;
        grid-template-rows: 1fr;
        grid-template-areas: "pme-content";
    }

    .pme-dashboard-content {
        grid-area: pme-content;
        margin: 8px 16px 0;
    }

    .pme-dashboard-menu {
        display: none;
        grid-area: pme-menu;
        margin: 8px 16px 0;
        position: fixed;
    }

    @media screen and (min-width: 800px) {

        .pme-dashboard {
            grid-template-columns: 268px auto;
            grid-template-areas: "pme-menu pme-content";
        }

        .pme-dashboard-menu {
            min-width: 268px;
            display: inherit;
        }

    }
</style>