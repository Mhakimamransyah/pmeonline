<template>
    <div class="medium-form">

        <div class="medium-form-content">

            <div class="ui raised segment">

                <div class="ui top attached progress" ref="progressBar">
                    <div class="bar"></div>
                </div>

                <a class="ui green ribbon label ribbon-sub-segment">{{ title }}</a>

                <div class="ui form">

                    <div class="two fields">

                        <div class="field five wide">
                            <label for="input-cycle">Siklus</label>
                            <select id="input-cycle" class="ui search fluid dropdown" v-on:change="cycleSelected">
                                <option value="">Pilih Siklus</option>
                                <option v-for="cycle in cycleList" v-bind:key="cycle.id" v-bind:value="cycle.id">{{ cycle.name }}</option>
                            </select>
                        </div>

                        <div class="field eleven wide">
                            <label for="input-package">Paket</label>
                            <select v-model="package_id" id="input-package" ref="inputPackage" class="ui search fluid dropdown" v-on:change="packageSelected">
                                <option value="">Pilih Paket</option>
                                <option v-for="pmePackage in packageList" v-bind:key="pmePackage.id" v-bind:value="pmePackage.id">{{ pmePackage.label }}</option>
                            </select>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>
</template>

<script>
    export default {
        name: "SelectCycleAndPackage",
        props: ['failedToFetchErrorMessage', 'filterPackage', 'title'],
        computed: {
            progressBar() {
                return $(this.$refs.progressBar);
            },
            inputPackage() {
                return $(this.$refs.inputPackage);
            },
        },
        data() {
            return {
                cycleList: [],
                packageList: [],
                package_id: null,
            }
        },
        methods: {
            fetchCycles() {
                this.progressBar.progress({ percent: 25 });
                axios.get('/v3/cycles').then(response => {
                    this.cycleList = response.data;
                    this.progressBar.progress({ percent: 100 });
                }).catch(error => {
                    console.log(error);
                    toastr.error(this.failedToFetchErrorMessage);
                });
            },
            fetchPackages(payload) {
                this.progressBar.progress({ percent: 25 });
                axios.get('/v3/packages', {
                    params: payload,
                    paramsSerializer: function(params) {
                        return qs.stringify(params, {encode: false})
                    }
                }).then(response => {
                    this.packageList = response.data;
                    if (this.filterPackage != null) {
                        this.packageList = this.packageList.filter(this.filterPackage);
                    }
                    this.progressBar.progress({ percent: 100 });
                })
            },
            cycleSelected(event) {
                let selectedCycle = event.target.value;
                this.package_id = null;
                this.inputPackage.dropdown('clear');
                this.fetchPackages({
                    filter: {
                        cycle_id: selectedCycle,
                    },
                    with: ['divisions'],
                });
            },
            packageSelected(event) {
                if (this.package_id === null || this.package_id === '') {
                    this.$emit('package-selected', null);
                    return;
                }
                let selectedPackage = this.packageList.filter(pmePackage => pmePackage.id === this.package_id)[0];
                this.$emit('package-selected', selectedPackage);
            }
        },
        mounted() {
            this.fetchCycles();
        },
    }
</script>

<style scoped>

</style>