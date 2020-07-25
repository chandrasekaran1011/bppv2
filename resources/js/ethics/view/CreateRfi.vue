<template>
<div>
    <v-card class="mx-auto" color="white" elevation-3 width="95%" height="100%" min-height="400px">
        <div>
            <h1 class="font-weight-bold py-3 my-2 d-inline-block display-1 basil--text">
                Request for Inspection (RFI)
            </h1>
        </div>
        <v-divider> </v-divider>

        <v-row :justify="'center'">
            <v-col cols="12" :md="6" :sm="12">
                <v-card color="white" elevation-3>
                    <v-card-text>
                        <v-select class="text-left" :items="contractList" item-text="name" item-value="id" v-model="contract" :error-messages="contractErrors" @input="$v.contract.$touch()" @blur="$v.contract.$touch()" label="Contract*"></v-select>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
        <div class="title grad">Document Reference</div>
        <v-row :justify="'center'" no-gutters>
            <v-col cols="12" class="pa-2" :md="12" :sm="12">
                <v-card color="white" class="pa-2" elevation-3>
                    <v-row no-gutters :justify="'space-around'">
                        <v-col cols="12" :md="3" :sm="12">
                            <v-text-field v-model="prev" label="Previous RFI Reference" name="prev"></v-text-field>
                        </v-col>
                        <v-col cols="12" :md="3" :sm="12">
                            <v-text-field v-model="method" :error-messages="methodErrors" @input="$v.method.$touch()" @blur="$v.method.$touch()" label="Method Statement Reference" name="method"></v-text-field>
                        </v-col>
                        <v-col cols="12" :md="3" :sm="12">
                            <v-text-field v-model="plan" :error-messages="planErrors" @input="$v.plan.$touch()" @blur="$v.plan.$touch()" label="Field Quality Plan" name="plan"></v-text-field>
                        </v-col>
                    </v-row>
                </v-card>
            </v-col>
        </v-row>
        <div class="title grad">Location of Activity</div>
        <v-row :justify="'center'" no-gutters>
            <v-col cols="12" class="pa-2" :md="12" :sm="12">
                <v-card color="white" class="pa-2" elevation-3>
                    <v-row no-gutters :justify="'space-around'">
                        <v-col cols="12" :md="3" :sm="12">
                            <v-text-field v-model="corridor" :error-messages="corridorErrors" @input="$v.corridor.$touch()" @blur="$v.corridor.$touch()" label="Corridor/ Section Ref" name="section"></v-text-field>
                        </v-col>
                        <v-col cols="12" :md="3" :sm="12">
                            <v-text-field v-model="reach" :error-messages="reachErrors" @input="$v.reach.$touch()" @blur="$v.reach.$touch()" label="Reach/Chainage No" name="reach"></v-text-field>
                        </v-col>
                        <v-col cols="12" :md="3" :sm="12">
                            <v-text-field v-model="pack" :error-messages="packErrors" @input="$v.pack.$touch()" @blur="$v.pack.$touch()" label="Package"></v-text-field>
                        </v-col>
                        <v-col cols="12" :md="6" :sm="12">
                            <v-text-field v-model="location" :error-messages="locationErrors" @input="$v.location.$touch()" @blur="$v.location.$touch()" label="Location of Work" name="location"></v-text-field>
                        </v-col>
                    </v-row>
                </v-card>
            </v-col>
        </v-row>
        <div class="title grad">Inspection Details</div>
        <v-row :justify="'center'" no-gutters>
            <v-col cols="12" class="pa-2" :md="12" :sm="12">
                <v-card color="white" class="pa-2" elevation-3>
                    <v-row no-gutters :justify="'space-around'">
                        <v-col cols="12" :md="12" :sm="12">
                            <v-row no-gutters :justify="'space-around'">
                                <v-col>
                                    <v-checkbox class="mx-2" v-model="hold" :error-messages="holdErrors" @input="$v.hold.$touch()" @blur="$v.hold.$touch()" :false-value="0" :true-value="1" name="hold" label="Quality Hold Point"></v-checkbox>
                                </v-col>
                                <v-col>
                                    <v-checkbox class="mx-2" v-model="control" :error-messages="controlErrors" @input="$v.control.$touch()" @blur="$v.control.$touch()" :false-value="0" :true-value="1" name="control" label="Quality Control Point"></v-checkbox>
                                </v-col>
                            </v-row>

                        </v-col>
                        <v-col cols="12" :md="12" :sm="12">
                            <v-textarea outlined v-model="activity" :error-messages="activityErrors" @input="$v.activity.$touch()" @blur="$v.activity.$touch()" name="activity" label="Activity to be Inspected" value=""></v-textarea>
                        </v-col>
                        <v-col class="text-left" style="text-align:left !important" cols="12" :md="8" :sm="12">
                            <v-select class="text-left" v-model="approver" :error-messages="approverErrors" @input="$v.approver.$touch()" @blur="$v.approver.$touch()" :items="approverList" item-text="name" item-value="id" label="Approver"></v-select>
                        </v-col>

                    </v-row>
                </v-card>
            </v-col>
        </v-row>

        <v-row :justify="'center'">
            <v-col cols="12" :md="6" :sm="12">
                <v-btn color="success" @click="sumform()" :disabled="$v.$invalid">Submit</v-btn>
            </v-col>
        </v-row>

    </v-card>

</div>
</template>

<style lang="scss">
.v-select__selection,
.v-list-item__content {
    width: 100%;
    justify-content: left;
}

.v-list-item__content {
    text-align: left !important;
}

.grad {
    color: white;
    background-color: #6b0f1a;
    background-image: linear-gradient(315deg, #6b0f1a 0%, #b91372 74%);
}


</style>

<script>
import axios from "../axios/axios";

import {
    required,
    integer,
    maxLength,

} from 'vuelidate/lib/validators'

export default {
    data: () => ({
        fab: false,

        contractList: [],
        approverList: [],

        search: '',

        contract: '',
        prev: '',
        method: '',
        plan: '',
        corridor: '',
        reach: '',
        pack: '',
        location: '',
        hold: 0,
        control: 0,
        activity: '',
        approver: '',

    }),

    methods: {
        getData() {
            axios.get(window.links.indexData).then((resp) => {
                this.contractList = resp.data.contracts
                this.approverList = resp.data.approver
            }).catch(() => {
                this.$store.commit('snackNotify', {
                    type: 'error',
                    msg: 'Error Fetching Contracts'
                });
            })
        },
        sumform() {
            if(this.$store.state.loading == true)return ;
            this.$store.state.loading = true;
            let formData = {};
            formData._token = document.getElementById('csrf').content;
            formData.contract = this.contract;
            formData.prev = this.prev;
            formData.method = this.method;
            formData.plan = this.plan;
            formData.corridor = this.corridor;
            formData.reach = this.reach;

            formData.pack = this.pack;
            formData.location = this.location;
            formData.hold = this.hold;
            formData.control = this.control;
            formData.activity = this.activity;
            formData.approver = this.approver;

            axios.post(window.links.createRfi,formData).then((resp) => {
                this.$store.commit('snackNotify', {
                    type: 'success',
                    msg: resp.data.message
                });
                this.resetform();
            }).catch((err) => {
                let errText = '';
                if (err.response.status) {
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
            }).then(()=>{
                this.$store.state.loading = false;
            })
        },
        resetform(){
            this.contract='';
            this.prev='';
            this.method='';
            this.plan='';
            this.corridor='';
            this.reach='';

            this.pack='';
            this.location='';
            this.hold='';
            this.control='';
            this.activity='';
            this.approver='';
            this.$v.$reset();
        }
    },
    created() {
        this.getData();
    },
    validations: {
        contract: {
            required,
            integer
        },
        method: {
            required,
        },
        plan: {
            required,
        },
        corridor: {
            required,
        },
        reach: {
            required,
        },
        pack: {
            required,
        },
        location: {
            required,
        },
        hold: {
            integer,
        },
        control: {
            integer
        },
        activity: {
            required
        },
        approver: {
            required
        }
    },
    computed: {
        contractErrors() {
            const errors = []
            if (!this.$v.contract.$dirty) {
                return errors
            }

            if (!this.$v.contract.required) {
                errors.push('Contract is required.')
            }

            if (!this.$v.contract.integer) {
                errors.push('Something went wrong.')
            }

            return errors
        },
        methodErrors() {
            const errors = []
            if (!this.$v.method.$dirty) {
                return errors
            }

            if (!this.$v.method.required) {
                errors.push('Method STatement Ref is required.')
            }

            return errors
        },
        planErrors() {
            const errors = []
            if (!this.$v.plan.$dirty) {
                return errors
            }

            if (!this.$v.plan.required) {
                errors.push('Quality Plan Ref is required.')
            }

            return errors
        },
        corridorErrors() {
            const errors = []
            if (!this.$v.corridor.$dirty) {
                return errors
            }

            if (!this.$v.corridor.required) {
                errors.push('Corridor Ref is required.')
            }

            return errors
        },
        reachErrors() {
            const errors = []
            if (!this.$v.reach.$dirty) {
                return errors
            }

            if (!this.$v.reach.required) {
                errors.push('Reach Ref is required.')
            }

            return errors
        },
        packErrors() {
            const errors = []
            if (!this.$v.pack.$dirty) {
                return errors
            }

            if (!this.$v.pack.required) {
                errors.push('Package Ref is required.')
            }

            return errors
        },
        locationErrors() {
            const errors = []
            if (!this.$v.location.$dirty) {
                return errors
            }

            if (!this.$v.location.required) {
                errors.push('Location Ref is required.')
            }

            return errors
        },
        holdErrors() {
            const errors = []
            if (!this.$v.hold.$dirty) {
                return errors
            }

            if (!this.$v.hold.integer) {
                errors.push('Something went wrong.')
            }

            return errors
        },
        controlErrors() {
            const errors = []
            if (!this.$v.control.$dirty) {
                return errors
            }

            if (!this.$v.control.integer) {
                errors.push('Something went wrong.')
            }

            return errors
        },
        approverErrors() {
            const errors = []
            if (!this.$v.approver.$dirty) {
                return errors
            }

            if (!this.$v.approver.required) {
                errors.push('Select Approver.')
            }

            return errors
        },
        activityErrors() {
            const errors = []
            if (!this.$v.activity.$dirty) {
                return errors
            }

            if (!this.$v.activity.required) {
                errors.push('Activity Ref is required.')
            }

            return errors
        },

    }
}
</script>
