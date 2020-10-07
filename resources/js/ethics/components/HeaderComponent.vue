<template>
<div>
    <v-app-bar app dark :color="'#003e4b'">

        <img src="https://www.systrausa.com/IMG/siteon0.png?1580122516" width="160px" height="30px" alt="img" />
        <v-toolbar-title class="ml-2 d-none ml-3 d-sm-none d-md-flex " style=" font-size: 2.1rem;font-weight: 900;">
            Business Partner Portal
        </v-toolbar-title>

        <v-toolbar-title class="ml-2 d-xs-flex ml-3 d-sm-flex d-md-none  " style="font-size: 2.1rem;font-weight: 900;">
            BPP
        </v-toolbar-title>
        <v-spacer></v-spacer>

        <v-btn icon @click.stop="$router.push('/');">
            <v-icon>fas fa-home</v-icon>
        </v-btn>
        <v-menu offset-y>
            <template v-slot:activator="{ on }">
                <v-btn icon v-on="on">
                    <v-icon>fas fa-user</v-icon>
                </v-btn>
            </template>

            <v-list>
                <v-list-item @click="() => {}">
                    <a :href="home" style="text-decoration:none;">
                        <v-list-item-title>Home</v-list-item-title>
                    </a>

                </v-list-item>

                <v-list-item @click="logout()">
                    <v-list-item-title>Logout</v-list-item-title>
                </v-list-item>
            </v-list>
        </v-menu>
    </v-app-bar>

    <v-snackbar v-model="$store.state.snackbar" :color="$store.state.snackbarType" bottom :timeout="8000">
        {{$store.state.snackbarText}}
        <v-btn color="white" text @click="$store.state.snackbar = false">
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
        },
        home: {
            type: String,
        }
    },
    data: () => ({
        drawer: null,
        item: 1,
    }),
    methods: {
        logout() {
            window.location.href = window.links.logout;
        },
        nav(val) {
            if (val == 1) {
                this.$router.push({
                    name: 'CreateRfi'
                })
            } else if (val == 2) {
                this.$router.push({
                    name: 'RfiApprovals'
                })
                this.item = 2;
            } else if (val == 3) {
                // this.$router.push({
                //     name: 'Users'
                // })
                this.item = 3;
            }

        }
    },
    created() {
        this.$store.state.tabId = 0;
    }
}
</script>
