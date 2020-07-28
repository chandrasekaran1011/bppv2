<template>
<div>
    <div class="text-center my-3">
        <v-btn class="ma-2" :loading="dataLoading" :disabled="dataLoading" color="success" @click="imsDialog=true">
            Approve
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
                <v-toolbar-title>Business Partner Registration - Compliance Approval</v-toolbar-title>

            </v-toolbar>

            <v-card class="mx-auto" color="white" elevation-3 width="100%" max-width="900px" min-width="600px" height="100%" min-height="400px">
                <div class="title grad text-left mt-3 pa-3">Compliance Manager Approval Form</div>
                
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
                        <div class="title1 text-left reqFields" for="name">Reason for Decision </div>
                    </v-col>
                    <v-col cols="12" :md="6">
                        <v-textarea outlined label="Reason for Decision" name="reason" id="reason" :error-messages="reasonErrors" @input="$v.reason.$touch()" @blur="$v.reason.$touch()" v-model="reason"></v-textarea>
                    </v-col>
                </v-row>

                <v-row :justify="'center'" class="px-4 py-2" no-gutters>
                    <v-col cols="12" :md="6">
                        <div class="title1 text-left " for="name">Additional Remarks </div>
                    </v-col>
                    <v-col cols="12" :md="6">
                        <v-textarea outlined label="Remarks" name="add" id="add" v-model="add"></v-textarea>
                    </v-col>
                </v-row>

                
                <v-row v-if="decision=='0' && data.status==8" :justify="'center'" class="mt-2  px-4 py-2" no-gutters>
                    <v-col cols="12" :md="6">
                        <div class="title1 text-left reqFields mt-3" for="name">Escalated Approval</div>
                    </v-col>
                    <v-col cols="12" :md="6" class="pl-md-3">
                        <v-autocomplete v-model="approver" :error-messages="approverErrors" @input="$v.approver.$touch()" @blur="$v.approver.$touch()" :items="data.status==3?data.groupUsers:data.committeUsers" item-text="name" item-value="unique" label="Compliance Approval Manager" placeholder="Start typing to Search" prepend-icon="fas fa-user"></v-autocomplete>
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
        
        decision: '',
        condition: '',
        reason: '',
        add: '',
        approver:''

    }),
    methods: {

        sumform() {

            if (this.$store.state.loading == true) return;
            this.$store.state.loading = true;

            let formData = new FormData();
            formData.append('_token', document.getElementById('csrf').content);
            formData.append('unique', this.id)

            formData.append('decision', this.decision)
            formData.append('condition', this.condition)
            formData.append('reason', this.reason)
            formData.append('add', this.add)
            formData.append('approver', this.approver)


            axios.post(window.links.escalationForm, formData, {
                headers: {
                    "Content-Type": "multipart/form-data"
                }
            }).then((resp) => {
                this.$store.commit('snackNotify', {
                    type: 'success',
                    msg: resp.data.message
                });
                this.decision= '';
                this.condition= '';
                this.reason= '';
                this.add= '';
                this.approver='';

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
        approver: {
            required: requiredIf(function () {
                return this.decision == '0' && this.data.status==8
            })
        },

    },
    computed: {

        
        approverErrors() {
            const errors = []
            if (!this.$v.approver.$dirty) {
                return errors
            }

            if (!this.$v.approver.required) {
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
