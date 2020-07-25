import Vue from "vue";
import VueRouter from "vue-router";
import store from "../store/store.js";

import Dashboard from "../components/Dashboard.vue";
import Roles from "../components/RolesComponent.vue";
import Users from "../components/UserComponent.vue";
import Entity from "../components/EntityComponent.vue";

Vue.use(VueRouter);

const routes = [
    {
        path: "/",
        name: "Dashboard",
        component: Dashboard,
        beforeEnter(to, from, next) {
            // store.state.isLoading = true;
            next();
        }
    },
    {
        path: "/roles",
        name: "Roles",
        component: Roles,
        beforeEnter(to, from, next) {
            // store.state.isLoading = true;
            next();
        }
    },
    {
        path: "/users",
        name: "Users",
        component: Users,
        beforeEnter(to, from, next) {
            // store.state.isLoading = true;
            next();
        }
    },
    {
        path: "/entity",
        name: "Entity",
        component: Entity,
        beforeEnter(to, from, next) {
            // store.state.isLoading = true;
            next();
        }
    }
];

export default new VueRouter({ routes });
