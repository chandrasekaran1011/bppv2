import Vue from "vue";
import VueRouter from "vue-router";
// import store from "../store/store.js";

import Dashboard from "../components/Dashboard.vue";
import CreatePartner from "../view/CreatePartner.vue";
import Detail from "../view/Detail.vue";
import ViewPartner from "../view/ViewPartner.vue";

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
        path: "/createPartner/:id",
        name: "CreatePartner",
        component: CreatePartner,
        beforeEnter(to, from, next) {
            // store.state.isLoading = true;
            next();
        }
    },
    ,
    {
        path: "/view",
        name: "View",
        component: ViewPartner,
        beforeEnter(to, from, next) {
            // store.state.isLoading = true;
            next();
        }
    },

    {
        path: "/detail/:id",
        name: "Detail",
        component: Detail,
        beforeEnter(to, from, next) {
            // store.state.isLoading = true;
            next();
        }
    }
];

export default new VueRouter({ routes });
