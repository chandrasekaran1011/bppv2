<template>
<div>
    <div class="text-center my-3">
        <v-btn class="ma-2" :loading="dataLoading" :disabled="dataLoading" color="success" @click="financeDialog=true">
            Financial Review
            <template v-slot:loader>
                <span class="custom-loader">
                    <v-icon light>fas fa-sync</v-icon>
                </span>
            </template>
        </v-btn>

    </div>
    <v-dialog v-model="financeDialog" fullscreen color="white" persistent transition="dialog-bottom-transition">
        <v-card>
            <v-toolbar dark color="primary">
                <v-btn icon dark @click="financeDialog = false">
                    <v-icon>fas fa-times</v-icon>
                </v-btn>
                <v-toolbar-title>Finance Review Business Partner</v-toolbar-title>

            </v-toolbar>

            <v-card class="mx-auto" color="white" elevation-3 width="100%" max-width="900px" min-width="600px" height="100%" min-height="400px">
                <div class="title grad text-left mt-3 pa-3">Finance Review Form</div>

                <v-row :justify="'center'" class="px-4 py-2" no-gutters>
                    <v-col cols="12" :md="6">
                        <div class="title1 text-left reqFields" for="name">Remarks </div>
                    </v-col>
                    <v-col cols="12" :md="6">
                        <v-textarea outlined label="Remarks" name="reason" id="reason" :error-messages="reasonErrors" @input="$v.reason.$touch()" @blur="$v.reason.$touch()" v-model="reason"></v-textarea>
                    </v-col>
                </v-row>


                <v-row :justify="'center'" class="mt-2 mb-4  px-4 py-2" no-gutters>
                    <v-btn :disabled="$v.$invalid" @click="sumform()" color="success">Submit</v-btn>
                </v-row>

            </v-card>
        </v-card>
    </v-dialog>
</div>
</template>

<script>
import axios from "../../axios/axios";
import {
    required,
    integer,
    maxLength,
    requiredIf,
    requiredUnless

} from 'vuelidate/lib/validators';
export default {
    props: {
        id: {
            required: true,
            type: String,
        },
        data: {
            required: true,
            type: Object
        }
    },
    data: () => ({
        financeDialog: false,
        dataLoading: false,
        reason: '',

    }),
    methods: {

        sumform() {

            if (this.$store.state.loading == true) return;
                       
            this.$store.state.loading = true;

            let formData = new FormData();
            formData.append('_token', document.getElementById('csrf').content);
            formData.append('unique', this.id);
            formData.append('reason', this.reason);

            axios.post(window.links.financeReview, formData, {
                headers: {
                    "Content-Type": "multipart/form-data"
                }
            }).then((resp) => {
                this.$store.commit('snackNotify', {
                    type: 'success',
                    msg: resp.data.message
                });

                this.reason = '';


            }).catch((err) => {
                let errText = '';
                if (err.response) {
                    console.log(err.response);
                    if (err.response.status = 422) {
                        Object.values(err.response.data.errors).forEach(val => {
                            errText += val + '\n';
                        });
                        this.$store.commit('snackNotify', {
                            type: 'error',
                            msg: errText
                        });
                    } else {
                        console.log(err.response);
                        this.$store.commit('snackNotify', {
                            type: 'error',
                            msg: err.response.data.message
                        });

                    }
                }
            }).then(() => {
                this.$store.state.loading = false;
                this.financeDialog = false;
                this.$emit('reset');
            })

        }
    },

    validations: {

        reason: {
            required
        },

    },
    computed: {

        reasonErrors() {
            const errors = []
            if (!this.$v.reason.$dirty) {
                return errors
            }

            if (!this.$v.reason.required) {
                errors.push('Field is required.')
            }
            return errors
        },

    },
    created() {

    }

}
</script>
