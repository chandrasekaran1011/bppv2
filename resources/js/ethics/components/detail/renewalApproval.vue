<template>
<div>
    <div class="text-center my-3">
        <v-btn class="ma-2" :loading="dataLoading" :disabled="dataLoading" color="success" @click="imsDialog=true">
            Compliance Approval
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
                <v-toolbar-title>Business Partner Renewal - Compliance Approval</v-toolbar-title>

            </v-toolbar>

            <v-card class="mx-auto" color="white" elevation-3 width="100%" max-width="900px" min-width="600px" height="100%" min-height="400px">
                <div class="title grad text-left mt-3 pa-3">Compliance Manager Approval Form</div>
                <v-row :justify="'center'" class="mt-2  px-4 py-2" no-gutters>
                    <v-col cols="12" :md="6">
                        <div class="title1 text-left reqFields mt-3" for="name">Enhanced integrity review performed? </div>
                    </v-col>
                    <v-col cols="12" :md="6">
                        <v-radio-group v-model="integrity" :error-messages="integrityErrors" @input="$v.integrity.$touch()" @blur="$v.integrity.$touch()" row>
                            <v-radio label="Yes" color="success" value="1"></v-radio>
                            <v-radio label="No" color="red" value="0"></v-radio>
                        </v-radio-group>
                    </v-col>
                </v-row>

                <v-row :justify="'center'" class=" px-4 py-2" no-gutters>
                    <v-col cols="12" :md="6">
                        <div class="title1 text-left reqFields  mt-3" for="name"> Attach Lexis Document</div>
                    </v-col>
                    <v-col cols="12" :md="6" class="pl-md-3">
                        <v-file-input :rules="rules" v-model="lexis_file" accept=".pdf" placeholder="Attach Lexis Document" prepend-icon="fas fa-file" label="Lexis Document"></v-file-input>
                    </v-col>
                </v-row>

                <v-row :justify="'center'" class="px-4 py-2" no-gutters>
                    <v-col cols="12" :md="12">
                        <div class="title1 text-left reqFields" for="name">Red flag identified from the enhanced integrity review and mitigating actions proposed: <br>
                            Amended action plan, if any </div>
                    </v-col>
                    <v-col cols="12" :md="12">
                        <v-textarea outlined label="Action plan" name="action" id="action" :error-messages="actionErrors" @input="$v.action.$touch()" @blur="$v.action.$touch()" v-model="action"></v-textarea>
                    </v-col>
                </v-row>

                <v-row :justify="'center'" class="mt-2  px-4 py-2" no-gutters>
                    <v-col cols="12" :md="4">
                        <div class="title1 text-left reqFields mt-3" for="name">Decision</div>
                    </v-col>
                    <v-col cols="12" :md="8">
                        <v-radio-group v-model="decision" :error-messages="decisionErrors" @input="$v.decision.$touch()" @blur="$v.decision.$touch()" row>
                            <v-radio label="Approved" color="success" value="1"></v-radio>
                            <v-radio label="Approved with Condition" color="success" value="2"></v-radio>
                            <v-radio label="Declined" color="red" value="0"></v-radio>
                        </v-radio-group>
                    </v-col>
                </v-row>

                <v-expand-transition>
                    <v-row v-if="decision=='2'" :justify="'center'" class="px-4 py-2" no-gutters>
                        <v-col cols="12" :md="6">
                            <div class="title1 text-left reqFields" for="name">Condition for Approval </div>
                        </v-col>
                        <v-col cols="12" :md="6">
                            <v-textarea outlined label="Condition for Approval" name="condition" id="condition" :error-messages="conditionErrors" @input="$v.condition.$touch()" @blur="$v.condition.$touch()" v-model="condition"></v-textarea>
                        </v-col>
                    </v-row>
                </v-expand-transition>

                <v-row :justify="'center'" class="px-4 py-2" no-gutters>
                    <v-col cols="12" :md="6">
                        <div class="title1 text-left reqFields" for="name">Reason of this Decision </div>
                    </v-col>
                    <v-col cols="12" :md="6">
                        <v-textarea outlined label="Reason of this Decision" name="reason" id="reason" :error-messages="reasonErrors" @input="$v.reason.$touch()" @blur="$v.reason.$touch()" v-model="reason"></v-textarea>
                    </v-col>
                </v-row>

                <v-row :justify="'center'" class="px-4 py-2" no-gutters>
                    <v-col cols="12" :md="6">
                        <div class="title1 text-left " for="name">Additional Information </div>
                    </v-col>
                    <v-col cols="12" :md="6">
                        <v-textarea outlined label="Remarks" name="add" id="add" v-model="add"></v-textarea>
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
        imsDialog: false,
        dataLoading: false,
        action: '',
        integrity: '1',
        decision: '',
        condition: '',
        reason: '',
        add: '',
        lexis_file: null,


    }),
    methods: {

        sumform() {

            if (this.$store.state.loading == true) return;
            this.$store.state.loading = true;

            let formData = new FormData();
            formData.append('_token', document.getElementById('csrf').content);
            formData.append('unique', this.id)
            formData.append('integrity', this.integrity)
            formData.append('flag_action', this.action)
            formData.append('decision', this.decision)
            formData.append('condition', this.condition)


            formData.append('reason', this.reason)
            formData.append('add', this.add)
            formData.append('lexis_file', this.lexis_file)

            axios.post(window.links.renewApprove, formData, {
                headers: {
                    "Content-Type": "multipart/form-data"
                }
            }).then((resp) => {
                this.$store.commit('snackNotify', {
                    type: 'success',
                    msg: resp.data.message
                });

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
                this.imsDialog = false;
                this.$emit('reset');
            })

        }
    },

    validations: {
        integrity: {
            required
        },
        action: {
            required
        },

        decision: {
            required
        },
        reason: {
            required
        },
        condition: {
            required: requiredIf(function () {
                return this.decision == '2'
            })
        },


    },
    computed: {
        integrityErrors() {
            const errors = []
            if (!this.$v.integrity.$dirty) {
                return errors
            }

            if (!this.$v.integrity.required) {
                errors.push('Field is required.')
            }
            return errors
        },
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
        actionErrors() {
            const errors = []
            if (!this.$v.action.$dirty) {
                return errors
            }

            if (!this.$v.action.required) {
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
        conditionErrors() {
            const errors = []
            if (!this.$v.condition.$dirty) {
                return errors
            }

            if (!this.$v.condition.required) {
                errors.push('Field is required.')
            }
            return errors
        },
    },
    created(){
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
