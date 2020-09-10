<template>
<div>
    <div class="text-center my-3">
        <v-btn class="ma-2" :loading="dataLoading" :disabled="dataLoading" color="success" @click="blacklistDialog=true">
            Blacklist Partner
            <template v-slot:loader>
                <span class="custom-loader">
                    <v-icon light>fas fa-sync</v-icon>
                </span>
            </template>
        </v-btn>

    </div>
    <v-dialog v-model="blacklistDialog" fullscreen color="white" persistent transition="dialog-bottom-transition">
        <v-card>
            <v-toolbar dark color="primary">
                <v-btn icon dark @click="blacklistDialog = false">
                    <v-icon>fas fa-times</v-icon>
                </v-btn>
                <v-toolbar-title>Blacklist Business Partner</v-toolbar-title>

            </v-toolbar>

            <v-card class="mx-auto" color="white" elevation-3 width="100%" max-width="900px" min-width="600px" height="100%" min-height="400px">
                <div class="title grad text-left mt-3 pa-3">Blacklisting Form</div>

                <v-row :justify="'center'" class="px-4 py-2" no-gutters>
                    <v-col cols="12" :md="6">
                        <div class="title1 text-left reqFields" for="name">Reason for Decision </div>
                    </v-col>
                    <v-col cols="12" :md="6">
                        <v-textarea outlined label="Reason for Decision" name="reason" id="reason" :error-messages="reasonErrors" @input="$v.reason.$touch()" @blur="$v.reason.$touch()" v-model="reason"></v-textarea>
                    </v-col>
                </v-row>

                <v-row :justify="'center'" class="px-4 py-2" no-gutters>
                    <v-col cols="12" :md="6">
                        <div class="title1 text-left reqFields" for="name">Blacklist Till </div>
                    </v-col>
                    <v-col cols="12" :md="6">
                        <v-menu ref="menu" v-model="dateMenu" :close-on-content-click="false"  transition="scale-transition" offset-y min-width="290px">
                            <template v-slot:activator="{ on, attrs }">
                                <v-text-field v-model="date" label="Blacklist Till" prepend-icon="fas fa-calendar" readonly v-bind="attrs" v-on="on"></v-text-field>
                            </template>
                            <v-date-picker v-model="date" no-title scrollable>
                                <v-spacer></v-spacer>
                                <v-btn text color="primary" @click="menu = false">Cancel</v-btn>
                                <v-btn text color="primary" @click="$refs.menu.save(date)">OK</v-btn>
                            </v-date-picker>
                        </v-menu>
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
        rules: [
            value => !value || value.size < 20000000 || 'File size should be less than 20 MB!',
        ],
        blacklistDialog: false,
        dataLoading: false,
        date:'',
        dateMenu:false,

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
            formData.append('date', this.date);

            axios.post(window.links.blacklistPartner, formData, {
                headers: {
                    "Content-Type": "multipart/form-data"
                }
            }).then((resp) => {
                this.$store.commit('snackNotify', {
                    type: 'success',
                    msg: resp.data.message
                });

                this.reason = '';
                this.date='';

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
                this.blacklistDialog = false;
                this.$emit('reset');
            })

        }
    },

    validations: {

        date: {
            required
        },
        reason: {
            required
        },

    },
    computed: {

        dateErrors() {
            const errors = []
            if (!this.$v.decision.$dirty) {
                return errors
            }

            if (!this.$v.decision.required) {
                errors.push('Field is required.')
            }
            return errors
        },
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
