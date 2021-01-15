<template>
    <header class="ui large green menu">
        <div class="ui container" id="menu-container">
            <a v-on:click="toHomepage" class="header item">
                {{ appName }}
            </a>
            <div class="right menu">
                <div class="ui dropdown item">
                    {{ username }}
                    <i class="dropdown icon"></i>
                    <div class="menu">
                        <a class="item" v-on:click="toChangePassword" id="changePasswordButton">
                            <i class="key icon"></i>
                            Ganti Password
                        </a>
                        <a class="item" v-on:click="toLogout" id="logoutButton">
                            <i class="logout icon"></i>
                            Logout
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <logout-dialog id="logoutDialog"></logout-dialog>
        <change-password-dialog v-bind:show-dialog="showChangePasswordDialog" v-on:close="showChangePasswordDialog = false"></change-password-dialog>
    </header>
</template>

<script>
    import LogoutDialog from "./LogoutDialog";
    import ChangePasswordDialog from "./ChangePasswordDialog";

    export default {
        name: "InstallationTopNav",
        data() {
            return {
                appName: window.config.appName,
                username: null,
                showChangePasswordDialog: false,
            }
        },
        components: {
            'logout-dialog': LogoutDialog,
            'change-password-dialog': ChangePasswordDialog,
        },
        methods: {
            toLogout(event) {
                setTimeout(_ => {
                    $('#logoutButton').removeClass('selected active');
                    $('#logoutDialog').modal('show');
                }, 0);
            },
            toChangePassword(event) {
                this.showChangePasswordDialog = true;
                setTimeout(_ => {
                    $('#changePasswordButton').removeClass('selected active');
                }, 0);
            },
            toHomepage(event) {
                router.push('/installation');
            },
        },
        mounted() {
            this.username = user.name;
            setTimeout(_ => {
                $('.dropdown').dropdown();
            }, 0);
        }
    }
</script>

<style scoped>
    #menu-container {
        width: 100%;
        margin-left: 0 !important;
        margin-right: 0 !important;
    }
</style>