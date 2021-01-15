<template>
    <layout selected-menu="statistic">
        <select-package title="Pilih Siklus dan Paket" v-on:package-selected="packageSelected" :filter-package="filterPackage"></select-package>
    </layout>
</template>

<script>
    import InstallationLayout from "../../layouts/InstallationLayout";
    import SelectCycleAndParameter from "../../components/SelectCycleAndPackage";

    export default {
        name: "InstallationStatistic",
        components: {
            'layout': InstallationLayout,
            'select-package': SelectCycleAndParameter
        },
        methods: {
            packageSelected(pmePackage) {
                if (pmePackage == null) {
                    toastr.success('paket belum pilih');
                    return;
                }
                toastr.success(pmePackage.label + ' terpilih');
            },
            filterPackage(pmePackage) {
                let currentDivision = pmePackage.divisions.filter(division => division.id.toString() === window.user.role.division.id.toString());
                return currentDivision.length > 0;
            }
        },
        mounted() {
        },
    }
</script>

<style scoped>

</style>