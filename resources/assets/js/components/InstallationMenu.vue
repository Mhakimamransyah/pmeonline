<template>
    <div class="ui vertical fluid tabular menu desktop-menu">
        <a class="item" v-bind:class="menuClass.scoring" v-on:click="toInstallationScoring">
            <i class="left edit icon"></i>
            Isian & Evaluasi Peserta
        </a>

        <a class="item" v-bind:class="menuClass.statistic" v-on:click="toInstallationStatistic">
            <i class="left recycle icon"></i>
            Statistik
        </a>
    </div>
</template>

<script>
    export default {
        name: "InstallationMenu",
        props: ['selectedMenu'],
        mounted() {
            if (this.selectedMenu === 'scoring') {
                this.menuClass.scoring = 'active';
            } else if (this.selectedMenu === 'statistic'){
                this.menuClass.statistic = 'active';
            }
        },
        methods: {
            toInstallationScoring(event) {
                router.push('/installation/scoring');
            },
            toInstallationStatistic(event) {
                router.push('/installation/statistic');
            },
        },
        data() {
            return {
                menuClass: {
                    scoring: '',
                    statistic: '',
                }
            }
        }
    }
</script>

<style scoped>

</style>