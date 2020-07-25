import Vue from "vue";
import Vuelidate from "vuelidate";
import Vuetify from "vuetify";
import store from "./store/store.js";
import router from "./router/router.js";

window.Vue = Vue;
Vue.use(Vuelidate);
Vue.use(Vuetify);
import Axios from "axios";

Vue.component("admin-header", require("./components/HeaderComponent").default);
Vue.component(
    "validation-errors",
    require("./components/ValidationComponent").default
);

Vue.prototype.$http = Axios;

const app = new Vue({
    el: "#app",
    router: router,
    store,
    vuetify: new Vuetify({
        icons: {
            iconfont: "fa"
        }
    })
});

router.beforeEach((to, from, next) => {
    store.state.loading = true;

    next();
});
