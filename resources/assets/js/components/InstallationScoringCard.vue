<template>
    <div class="medium-form">

        <div class="medium-form-content">

            <div class="ui raised segment">

                <div class="ui top attached progress" ref="progressBar">
                    <div class="bar"></div>
                </div>

                <a class="ui green ribbon label ribbon-sub-segment">Isian dan Evaluasi Peserta</a>

                <scoring-table v-bind:order-list="orderList" v-on:order-selected="orderSelected"></scoring-table>

            </div>

        </div>

    </div>
</template>

<script>
    import InstallationScoringTable from "./InstallationScoringTable";

    export default {
        name: "InstallationScoringCard",
        props: ['pmePackage'],
        data() {
            return {
                orderList: [],
            }
        },
        components: {
            'scoring-table': InstallationScoringTable,
        },
        computed: {
            progressBar() {
                return $(this.$refs.progressBar);
            },
            filterForm() {
                return {
                    package_id: this.computePackageId,
                };
            },
            computePackageId() {
                if (this.pmePackage == null) {
                    return null;
                }
                return this.pmePackage.id;
            },
        },
        watch: {
            pmePackage(newVal, oldVal) {
                if (newVal === oldVal) {
                    return;
                }
                this.orderList = [];
                if (newVal == null) {
                    return;
                }
                if (this.filterForm.package_id === null || this.filterForm.package_id.toString() === '') {
                    return;
                }
                this.progressBar.progress({ percent: 25 });
                axios.get('/v3/orders', {
                    params: {
                        filter: this.filterForm,
                        with: ['submit', 'invoice', 'invoice.laboratory', 'invoice.laboratory.province']
                    },
                    paramsSerializer: function (params) {
                        return qs.stringify(params, {encode: false});
                    }
                }).then(response => {
                    this.progressBar.progress({ percent: 50 });
                    this.orderList = response.data;
                    this.progressBar.progress({ percent: 100 });
                }).catch(error => {
                    console.log(error);
                    toastr.error("Terjadi kesalahan saat memuat daftar isian dan evaluasi peserta. Silakan lihat log untuk rincian kesalahan.");
                });
            }
        },
        methods: {
            evaluateButtonClicked(item) {
                console.log(item);
            },
            orderSelected(selectedOrder) {
                this.$emit('order-selected', selectedOrder);
            },
        },
        mounted() {
            this.progressBar.progress({ percent: 0 });
        },
    }
</script>

<style scoped>

</style>