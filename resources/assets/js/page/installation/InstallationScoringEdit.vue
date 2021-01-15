<template>
    <layout selected-menu="scoring">
        <div class="medium-form">
            <div class="medium-form-content">
                <div class="ui raised segment clearing">
                    <div class="ui top attached progress" ref="progressBar">
                        <div class="bar"></div>
                    </div>
                    <dynamic-form :submit="submit" v-if="submit != null && submit.value != null"></dynamic-form>
                </div>
            </div>
        </div>
    </layout>
</template>

<script>
    import InstallationLayout from "../../layouts/InstallationLayout";
    import DynamicScoringForm from "../../components/DynamicScoringForm";

    export default {
        name: "InstallationScoringEdit",
        components: {
            'layout': InstallationLayout,
            'dynamic-form': DynamicScoringForm,
        },
        data() {
            return {
                submit: null,
            }
        },
        computed: {
            progressBar() {
                return $(this.$refs.progressBar);
            },
        },
        props: ['submit_id'],
        mounted() {
            this.progressBar.progress({ percent: 25 });
            axios.get('/v3/submits', {
                params: {
                    filter: {
                        id: this.submit_id,
                    },
                    with: ['order', 'order.invoice', 'order.package', 'order.invoice.laboratory'],
                    first: true,
                },
                paramsSerializer: function (params) {
                    return qs.stringify(params, {encode: false})
                }
            }).then(response => {
                this.progressBar.progress({ percent: 50 });
                this.submit = response.data;
                this.progressBar.progress({ percent: 100 });
            }).catch(error => {
                console.log(error);
            });
        }
    }
</script>

<style scoped>

</style>