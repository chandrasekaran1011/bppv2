import Vue from "vue";
import VueRouter from "vue-router";
// import store from "../store/store.js";

import Dashboard from "../components/Dashboard.vue";
import CreatePartner from "../view/CreatePartner.vue";
import Detail from "../view/Detail.vue";
import ViewPartner from "../view/ViewPartner.vue";
import SearchPartner from "../view/SearchPartner.vue";
import ReportIndex from "../view/ReportIndex.vue";
import MonthlyReport from "../view/reports/MonthlyReport.vue";
import MasterReport from "../view/reports/MasterReport.vue";
import BPDashboard from "../view/BPDashboard.vue";

import PendingPartner from "../view/PendingApproval.vue";
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
        path: "/pendingApproval",
        name: "Pending",
        component: PendingPartner,
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
    },

    {
        path: "/search",
        name: "SearchPartner",
        component: SearchPartner,
        beforeEnter(to, from, next) {
            // store.state.isLoading = true;
            next();
        }
    },

    {
        path: "/reports",
        name: "ReportIndex",
        component: ReportIndex,
        beforeEnter(to, from, next) {
            // store.state.isLoading = true;
            next();
        }
    },
    {
        path: "/reports/monthly",
        name: "MonthlyReport",
        component: MonthlyReport,
        beforeEnter(to, from, next) {
            // store.state.isLoading = true;
            next();
        }
    },
    {
        path: "/reports/master",
        name: "MasterReport",
        component: MasterReport,
        beforeEnter(to, from, next) {
            // store.state.isLoading = true;
            next();
        }
    },
    {
        path: "/dashboard",
        name: "BPDashboard",
        component: BPDashboard,
        beforeEnter(to, from, next) {
            // store.state.isLoading = true;
            next();
        }
    }
];

export default new VueRouter({ routes });
