<template>
    <layout selected-menu="scoring">
        <select-package title="Pilih Siklus dan Paket" v-on:package-selected="packageSelected" :filter-package="filterPackage"></select-package>
        <scoring-card v-bind:pme-package="selectedPackage" v-on:order-selected="orderSelected"></scoring-card>
    </layout>
</template>

<script>
    import InstallationLayout from "../../layouts/InstallationLayout";
    import InstallationScoringCard from "../../components/InstallationScoringCard";
    import SelectCycleAndPackage from "../../components/SelectCycleAndPackage";

    export default {
        name: "InstallationScoring",
        components: {
            'layout': InstallationLayout,
            'select-package': SelectCycleAndPackage,
            'scoring-card': InstallationScoringCard,
        },
        data() {
            return {
                selectedPackage: null,
            }
        },
        methods: {
            packageSelected(pmePackage) {
                this.selectedPackage = pmePackage;
            },
            filterPackage(pmePackage) {
                let currentDivision = pmePackage.divisions.filter(division => division.id.toString() === window.user.role.division.id.toString());
                return currentDivision.length > 0;
            },
            orderSelected(selectedOrder) {
                let route = this.$router.resolve({
                    path: '/installation/scoring/edit',
                    query: {
                        submit_id: selectedOrder.submit.id,
                    }
                });
                window.open(route.href, '_blank');
            }
        }
    }
</script>

<style scoped>

</style>