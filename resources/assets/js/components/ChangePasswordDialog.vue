<template>
    <div class="ui mini modal" ref="changePasswordDialog">
        <div class="header">
            Ganti Password
        </div>
        <div class="content">
            <div class="ui form">
                <div class="ui field">
                    <label for="input_new_password">{{ 'Password Baru' }}</label>
                    <input id="input_new_password" class="form-control" type="password" name="password" required v-model="changePasswordForm.password">
                </div>

                <div class="ui field">
                    <label for="input_confirm_new_password">{{ 'Ulangi Password Baru' }}</label>
                    <input id="input_confirm_new_password" class="form-control" type="password" name="password_confirmation" required v-model="changePasswordForm.password_confirmation">
                </div>
            </div>
        </div>
        <div class="actions">
            <div class="ui positive right labeled icon button">
                Simpan Password Baru
                <i class="checkmark icon"></i>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ChangePasswordDialog",
        props: ['showDialog'],
        data() {
            return {
                changePasswordForm: {
                    password: null,
                    password_confirmation: null,
                },
            }
        },
        watch: {
            showDialog: function (newVal, oldVal) {
                console.log(newVal);
                let vue = this;
                if (newVal) {
                    $(this.$refs.changePasswordDialog)
                        .modal({
                            onApprove() {
                                return vue.approveChangePassword();
                            },
                            onHide() {
                                vue.$emit('close', true);
                            },
                        })
                        .modal('show');
                }
            }
        },
        mounted() {
        },
        methods: {
            approveChangePassword() {
                let vue = this;
                if (this.changePasswordForm.password === this.changePasswordForm.password_confirmation) {
                    axios.post('/vue/password/update', this.changePasswordForm).then(response => {
                        console.log(response.data);
                        toastr.success('Password berhasil disimpan');
                        vue.resetChangePasswordForm();
                    }).catch(error => {
                        console.log(error.response.data);
                        for (let elem in error.response.data.errors) {
                            toastr.error(error.response.data.errors[elem]);
                        }
                    });
                    return true;
                }
                toastr.error('Password baru tidak cocok');
                return false;
            },
            resetChangePasswordForm() {
                this.changePasswordForm.password = null;
                this.changePasswordForm.password_confirmation = null;
            }
        }
    }
</script>

<style scoped>

</style>