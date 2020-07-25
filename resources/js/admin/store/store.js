import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        snackbar: false,
        snackbarText: "",
        snackbarType: "success",
        loading: false,
        tabId: 1
    },
    mutations: {
        snackNotify(state, payload) {
            state.snackbarType = payload.type;
            state.snackbarText = payload.msg;
            state.snackbar = true;
        },
        loading(state, val) {
            state.loading = val;
        }
    },
    actions: {}
});
