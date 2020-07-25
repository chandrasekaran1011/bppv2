<template>
<div>

    <v-navigation-drawer v-model="drawer" app>
        <v-list shaped>
            <v-list-item-group v-model="$store.state.tabId" color="primary">
                <v-list-item @click="nav(1)">
                    <v-list-item-action>
                        <v-icon>fas fa-home</v-icon>
                    </v-list-item-action>
                    <v-list-item-content style="text-align:left">
                        <v-list-item-title>Dashboard</v-list-item-title>
                    </v-list-item-content>

                </v-list-item>
                <v-list-item @click="nav(2)">
                    <v-list-item-action>
                        <v-icon>fas fa-plus</v-icon>
                    </v-list-item-action>
                    <v-list-item-content style="text-align:left">
                        <v-list-item-title>Role Management</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>

                <v-list-item @click="nav(3)">
                    <v-list-item-action>
                        <v-icon>fas fa-user</v-icon>
                    </v-list-item-action>
                    <v-list-item-content style="text-align:left">
                        <v-list-item-title>User Management</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>

                <v-list-item @click="nav(4)">
                    <v-list-item-action>
                        <v-icon>fas fa-check</v-icon>
                    </v-list-item-action>
                    <v-list-item-content style="text-align:left">
                        <v-list-item-title>Manage Entity</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>

            </v-list-item-group>
        </v-list>
    </v-navigation-drawer>

    <v-app-bar app :color="'#cc2228'" dark>
        <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
        <v-toolbar-title>Portal Admin</v-toolbar-title>
        <v-spacer></v-spacer>

        <v-menu offset-y>
            <template v-slot:activator="{ on }">
                <v-btn icon v-on="on">
                    <v-icon>fas fa-user</v-icon>
                </v-btn>
            </template>

            <v-list>
                <v-list-item @click="() => {}">
                    <v-list-item-title>Account</v-list-item-title>
                </v-list-item>
                <v-list-item @click="logout()">
                    <v-list-item-title>Logout</v-list-item-title>
                </v-list-item>
            </v-list>
        </v-menu>
    </v-app-bar>

    <v-snackbar v-model="$store.state.snackbar" :color="$store.state.snackbarType" top :timeout="4000">
        {{$store.state.snackbarText}}
        <v-btn color="white" text @click="snackbar = false">
            Close
        </v-btn>
    </v-snackbar>
    <v-overlay :value="$store.state.loading" :z-index="10000">
        <div class="lds-ellipsis">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
        <div class="text-center">Loading </div>
    </v-overlay>

</div>
</template>

<style>
#app {
    font-family: Avenir, Helvetica, Arial, sans-serif;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    text-align: center;
    color: #2c3e50;
}

.lds-ellipsis {
    display: inline-block;
    position: relative;
    width: 80px;
    height: 80px;
}

.lds-ellipsis div {
    position: absolute;
    top: 33px;
    width: 13px;
    height: 13px;
    border-radius: 50%;
    background: #fff;
    animation-timing-function: cubic-bezier(0, 1, 1, 0);
}

.lds-ellipsis div:nth-child(1) {
    left: 8px;
    animation: lds-ellipsis1 0.6s infinite;
}

.lds-ellipsis div:nth-child(2) {
    left: 8px;
    animation: lds-ellipsis2 0.6s infinite;
}

.lds-ellipsis div:nth-child(3) {
    left: 32px;
    animation: lds-ellipsis2 0.6s infinite;
}

.lds-ellipsis div:nth-child(4) {
    left: 56px;
    animation: lds-ellipsis3 0.6s infinite;
}

@keyframes lds-ellipsis1 {
    0% {
        transform: scale(0);
    }

    100% {
        transform: scale(1);
    }
}

@keyframes lds-ellipsis3 {
    0% {
        transform: scale(1);
    }

    100% {
        transform: scale(0);
    }
}

@keyframes lds-ellipsis2 {
    0% {
        transform: translate(0, 0);
    }

    100% {
        transform: translate(24px, 0);
    }
}
</style>

<script>
export default {
    props: {
        links: {
            type: Object,
            // required: true,
        }
    },
    data: () => ({
        drawer: null,
        item: 1,
    }),
    methods: {
        logout() {

            window.location.href = window.links.logout;
            // const formData = {};
            // formData._token = document.getElementById('csrf').content;
            // axios.post(window.links.logout, formData)
            //     .then(res => {

            //         console.log('Logout')
            //     })
            //     .catch(err => {
            //         console.error(err);
            //     })
        },
        nav(val) {
            if (val == 1) {
                 this.$router.push({
                    name: 'Dashboard'
                 })
            } else if (val == 2) {
                this.$router.push({
                    name: 'Roles'
                })
                this.item = 2;
            } else if (val == 3) {
                this.$router.push({
                    name: 'Users'
                })
                this.item = 3;
            } else if (val == 4) {
                this.$router.push({
                    name: 'Entity'
                })
                this.item = 4;
            } 

        }
    }
}
</script>
