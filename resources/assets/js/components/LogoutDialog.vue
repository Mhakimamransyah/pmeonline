<template>
    <div class="ui basic modal">
        <div class="ui icon header">
            <i class="logout icon"></i>
            Apakah Anda hendak keluar dari aplikasi?
        </div>
        <div class="actions">
            <div class="ui red basic cancel inverted button">
                <i class="remove icon"></i>
                Tidak Jadi
            </div>
            <div class="ui green ok inverted button" v-on:click="submitLogout">
                <i class="checkmark icon"></i>
                Ya, Keluar
            </div>
        </div>
        <form id="logoutForm" action="/logout" method="POST" style="display: none;">
            <input name="_token" :value="csrf_token">
        </form>
    </div>
</template>

<script>
    export default {
        name: "LogoutDialog",
        methods: {
            submitLogout(event) {

                setTimeout(_ => {
                    $('#logoutForm').submit();
                }, 0)
            },
        },
        data() {
            return {
                csrf_token: window.csrf_token,
            }
        }
    }
</script>

<style scoped>
    .actions {
        text-align: center !important;
    }
</style>