<template>
<div>
    <div class="text-center my-3">
        <v-btn class="ma-2" :loading="dataLoading" :disabled="dataLoading" color="success" @click="imsDialog=true">
            Need confirmation
            <template v-slot:loader>
                <span class="custom-loader">
                    <v-icon light>fas fa-sync</v-icon>
                </span>
            </template>
        </v-btn>

    </div>
    <v-dialog v-model="imsDialog" fullscreen color="white" persistent transition="dialog-bottom-transition">
        <v-card>
            <v-toolbar dark color="primary">
                <v-btn icon dark @click="imsDialog = false">
                    <v-icon>fas fa-times</v-icon>
                </v-btn>
                <v-toolbar-title>Business Partner Registration -  Entity Head Need Confirmation </v-toolbar-title>

            </v-toolbar>

            <v-card class="mx-auto" color="white" elevation-3 width="100%" max-width="900px" min-width="600px" height="100%" min-height="400px">
                <div class="title grad text-left mt-3 pa-3"> Entity Head Need Confirmation Form</div>

                <v-row :justify="'center'" class="mt-2  px-4 py-2" no-gutters>
                    <v-col cols="12" :md="6">
                        <div class="title1 text-left reqFields mt-3" for="name"> Do you want to proceed with Ethics Committee?</div>
                    </v-col>
                    <v-col cols="12" :md="6">
                        <v-radio-group v-model="decision" :error-messages="decisionErrors" @input="$v.decision.$touch()" @blur="$v.decision.$touch()" row>
                            <v-radio label="Yes" color="success" value="1"></v-radio>
                            <v-radio label="No" color="red" value="0"></v-radio>
                        </v-radio-group>
                    </v-col>
                </v-row>

                <v-row :justify="'center'" class="px-4 py-2" no-gutters>
                    <v-col cols="12" :md="4">
                        <div class="title1 text-left reqFields" for="name">Reason for Pursuance </div>
                    </v-col>
                    <v-col cols="12" :md="8">
                        <v-textarea outlined label="Reason of this Decision" name="reason" id="reason" :error-messages="reasonErrors" @input="$v.reason.$touch()" @blur="$v.reason.$touch()" v-model="reason"></v-textarea>
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

        imsDialog: false,
        dataLoading: false,

        decision: '',

        reason: '',

    }),
    methods: {

        sumform() {

            if (this.$store.state.loading == true) return;
            this.$store.state.loading = true;

            let formData = new FormData();
            formData.append('_token', document.getElementById('csrf').content);
            formData.append('unique', this.id)
            formData.append('decision', this.decision)
            formData.append('reason', this.reason)

            axios.post(window.links.pursuance, formData, {
                headers: {
                    "Content-Type": "multipart/form-data"
                }
            }).then((resp) => {
                this.$store.commit('snackNotify', {
                    type: 'success',
                    msg: resp.data.message
                });
                this.decision = '';
                this.reason = '';

            }).catch((err) => {
                let errText = '';
                if (err.response) {
                    console.log(err.response);
                    if (err.response.status == 422) {
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
                this.imsDialog = false;
                this.$emit('reset');
            })

        }
    },

    validations: {

        decision: {
            required
        },
        reason: {
            required
        },

    },
    computed: {
       
        decisionErrors() {
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

<style lang="scss">
.custom-loader {
    animation: loader 1s infinite;
    display: flex;
}

@-moz-keyframes loader {
    from {
        transform: rotate(0);
    }

    to {
        transform: rotate(360deg);
    }
}

@-webkit-keyframes loader {
    from {
        transform: rotate(0);
    }

    to {
        transform: rotate(360deg);
    }
}

@-o-keyframes loader {
    from {
        transform: rotate(0);
    }

    to {
        transform: rotate(360deg);
    }
}

@keyframes loader {
    from {
        transform: rotate(0);
    }

    to {
        transform: rotate(360deg);
    }
}

.title1 {
    padding-top: 12px;
    font-weight: bolder;
}
</style>
