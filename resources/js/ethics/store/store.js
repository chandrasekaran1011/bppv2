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
        },
        errorFunction: (state, err) => {
            let errText = "";

            if (err.status == 422) {
                Object.values(err.data.errors).forEach(val => {
                    errText += val + "\n";
                });
                console.log(errText);
                state.snackbarText = errText;
                state.snackbarType = "error";
                state.snackbar = true;
            } else {
                console.log(err.response);
                if (err.response.data.message) {
                    state.snackbarText = err.response.data.message;
                } else {
                    state.snackbarText = "Something went wrong";
                }

                state.snackbarType = "error";
                state.snackbar = true;
            }
        }
    },
    actions: {}
});
