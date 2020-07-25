<template>
<div>
    <v-speed-dial style="position:absolute" v-model="fab" :top="true" :right="true" :direction="'bottom'" :open-on-hover="false">
        <template v-slot:activator>
            <v-btn v-model="fab" color="blue darken-2" dark fab>
                <v-icon v-if="fab">fas fa-times</v-icon>
                <v-icon v-else>fas fa-cogs</v-icon>
            </v-btn>
        </template>
        <v-btn fab dark small color="green" @click="dialog=!dialog;getMasterData();">
            <v-icon>fas fa-plus</v-icon>
        </v-btn>

        <v-btn fab dark small color="red">
            <v-icon>fas fa-trash</v-icon>
        </v-btn>
    </v-speed-dial>
    <div>

        <h1 class="font-weight-bold py-3 my-2 d-inline-block display-1 basil--text">
            Activity Groups

        </h1>

    </div>
    <v-skeleton-loader v-if="dataLoad" ref="skeleton" :boilerplate="true" :type="'table'" class="mx-auto"></v-skeleton-loader>
    <v-data-table v-else :headers="headers" :search="search" :items="groupList" :items-per-page="10" class="elevation-1">
        <template v-slot:item.action="{ item }">
            <v-btn fab x-small :color="'success'" class="mr-2" @click="openGroup(item.unique)">
                <v-icon>fas fa-search</v-icon>
            </v-btn>
            <v-btn fab x-small :color="'primary'" class="mr-2" @click="editItem(item)">
                <v-icon>fas fa-pencil-alt</v-icon>
            </v-btn>

            <v-btn fab x-small :color="'error'" class="mr-2" @click="console.log('click del')">
                <v-icon>fas fa-times</v-icon>
            </v-btn>

        </template>
    </v-data-table>

    <v-dialog v-model="dialog" persistent max-width="600px">

        <v-card>
            <v-card-title>
                <span class="headline">Create Activity Group</span>
            </v-card-title>
            <v-card-text>
                <v-container class="text-left">

                    <v-skeleton-loader v-if="cLoad" class="mx-auto" max-width="600" type="card"></v-skeleton-loader>

                    <v-row v-if="!cLoad">
                        <v-col cols="12" sm="12" md="12">
                            <v-text-field v-model="name" :error-messages="nameErrors" @input="$v.name.$touch()" @blur="$v.name.$touch()" label="Activity Group Name*" required></v-text-field>
                        </v-col>
                        <v-col cols="12" sm="12" md="12">
                            <v-select :items="disciplineList" item-text="name" item-value="id" v-model="discipline" :error-messages="disciplineErrors" @input="$v.discipline.$touch()" @blur="$v.discipline.$touch()" label="Discipline*"></v-select>
                        </v-col>
                        <v-col cols="12" sm="12" md="12">
                            <v-select class="text-left" :items="contractList" item-text="name" item-value="cid" v-model="contract" :error-messages="contractErrors" @input="$v.contract.$touch()" @blur="$v.contract.$touch()" label="Contract*"></v-select>
                        </v-col>
                        <v-col cols="12" sm="12" md="12">
                            <v-select :items="locationList" item-text="name" item-value="id" v-model="location" :error-messages="locationErrors" @input="$v.location.$touch()" @blur="$v.location.$touch()" label="Location*"></v-select>
                        </v-col>
                        <v-col cols="12" sm="12" md="12">
                            <v-text-field name="weightage" label="Weightage to Project" v-model="weightage" :error-messages="weightageErrors" @input="$v.weightage.$touch()" @blur="$v.weightage.$touch()"></v-text-field>
                        </v-col>

                    </v-row>
                </v-container>
                <!-- <small>*indicates required field</small> -->
            </v-card-text>
            <v-card-actions v-if="!cLoad">
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" text @click="dialog = false">Close</v-btn>
                <v-btn v-if="formMode=='create'" :disabled="$v.$invalid" color="blue darken-1" text @click="subform()">Save</v-btn>
                <v-btn v-else color="blue darken-1" text @click="subform(pid)">Update</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</div>
</template>

<style scoped>
.v-select-list {
    text-align: left;
}
</style>

<script>
import axios from "../axios/axios";
import {
    required,
    numeric,
    maxLength,
    decimal,
    maxValue,
    minValue

} from 'vuelidate/lib/validators'
export default {
    data: () => ({
        fab: false,
        dialog: false,
        cLoad: false,
        dataLoad: false,

        headers: [{
                text: 'Code',
                value: 'code'
            },
            {
                text: 'GroupName',
                value: 'name'
            },

            {
                text: 'Contract',
                value: 'contract[1]'
            },
            {
                text: 'Weightage',
                value: 'weightage',

            },
            {
                text: '% Completed',
                value: 'completed',
            },
            {
                text: 'Action',
                value: 'action',
                sortable: false,
            }

        ],
        items: [],
        search: '',
        disciplineList: [],
        contractList: [],
        locationList: [],

        name: "",
        discipline: '',
        location: "",
        contract: "",
        weightage: '',
        formMode: 'create',
        groupList: [],
        pid: ''
    }),
    methods: {
        subform(pid = 0) {
            if (this.$store.state.loading == true) return;
            this.$store.state.loading = true;
            this.$v.$reset();

            const formData = {};
            formData._token = document.getElementById('csrf').content;
            formData.name = this.name;
            formData.discipline = this.discipline;
            formData.contract = this.contract;
            formData.location = this.location;
            formData.weightage = this.weightage;

            let url = '';

            if (this.formMode == 'create') {
                url = window.links.createActivityGroup;
            } else {
                url = window.links.updateActivityGroup;
                formData.id = pid;
            }
            
            axios.post(url, formData)
                .then(res => {

                    this.$store.commit('snackNotify', {
                        type: 'success',
                        msg: res.data.message
                    });
                    this.dialog = false;
                    this.formReset();
                    this.getActivityGroups();

                })
                .catch(err => {
                    let errText = '';
                    console.log(err);
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
                            this.dialog = false
                        }
                    }

                }).then(() => {
                    this.$store.state.loading = false;
                })

        },
        formReset() {
            this.name = '';
            this.discipline = '';
            this.contract = '';
            this.location = '';
            this.weightage = '';
            this.$v.$reset();
        },
        editItem(data) {
            this.getMasterData();
            console.log(data.contract[0]);
            this.name = data.name;
            this.discipline = data.discipline[0];
            this.contract = data.contract[0];
            this.location = data.location[0];
            this.weightage = data.weightage;
            this.$v.$reset();
            this.formMode = 'update';
            this.pid = data.unique;
            this.dialog = true;
        },
        openGroup(uuid){
            this.$router.push({'name':'ActivityGroupDetail',params:{'id':uuid}})
        },
        getActivityGroups() {
            this.dataLoad = true;
            let formData = {};
            formData._token = document.getElementById('csrf').content;

            axios.post(window.links.viewActivityGroup, formData).then(resp => {
                this.groupList = resp.data;
            }).then(() => {
                this.dataLoad = false;
            }).catch(() => {
                this.$store.commit('snackNotify', {
                    type: 'error',
                    msg: 'Something Went Wrong'
                });
            })
        },
        getMasterData() {
            this.cLoad = true;
            var data = JSON.parse(localStorage.getItem('masterData'));
            var masterData = {};
            if (data) {

                if (data.expiry > Date.now()) {

                    masterData = JSON.parse(localStorage.getItem('masterData')).data;
                    this.locationList = masterData['location'];
                    this.contractList = masterData['contract'];
                    this.disciplineList = masterData['discipline'];
                    this.cLoad = false;
                } else {

                    this.loadMasterData();

                }
            } else {
                this.loadMasterData();
            }

        },
        loadMasterData() {
            let formData = {};
            formData._token = document.getElementById('csrf').content;

            axios.post(window.links.getMasterData, formData).then(resp => {

                var dt = new Date();
                var expTime = dt.setMinutes(dt.getMinutes() + 15);

                var myd = {
                    data: resp.data,
                    expiry: expTime
                }

                localStorage.setItem('masterData', JSON.stringify(myd));

            }).catch(err => {
                console.log('Master Error')
            }).then(() => {

                var masterData = JSON.parse(localStorage.getItem('masterData')).data;
                this.locationList = masterData['location'];
                this.contractList = masterData['contract'];
                this.disciplineList = masterData['discipline'];
                this.cLoad = false;

            })
        }
    },
    validations: {
        name: {
            required,
            maxLength: maxLength(40)
        },
        discipline: {
            required,
            numeric
        },
        contract: {
            required,
            numeric
        },
        location: {
            required,
            numeric
        },
        weightage: {
            required,
            decimal,
            maxValue: maxValue(100),
            minValue: minValue(0)
        },

    },
    computed: {
        nameErrors() {
            const errors = []
            if (!this.$v.name.$dirty) {
                return errors
            }
            if (!this.$v.name.maxLength) {
                errors.push('Name must be at most 40 characters long')
            }

            if (!this.$v.name.required) {
                errors.push('Name is required.')
            }

            return errors

        },
        disciplineErrors() {
            const errors = []
            if (!this.$v.discipline.$dirty) {
                return errors
            }

            if (!this.$v.discipline.required) {
                errors.push('Discipline is required.')
            }
            if (!this.$v.discipline.numeric) {
                errors.push('Something went wrong .')
            }

            return errors
        },
        contractErrors() {
            const errors = []
            if (!this.$v.contract.$dirty) {
                return errors
            }

            if (!this.$v.contract.required) {
                errors.push('Contract is required.')
            }

            if (!this.$v.contract.numeric) {
                errors.push('Something went wrong.')
            }

            return errors
        },
        locationErrors() {
            const errors = []
            if (!this.$v.location.$dirty) {
                return errors
            }

            if (!this.$v.location.required) {
                errors.push('Location is required.')
            }

            if (!this.$v.location.numeric) {
                errors.push('Something went wrong.')
            }

            return errors
        },
        weightageErrors() {
            const errors = []
            if (!this.$v.weightage.$dirty) {
                return errors
            }

            if (!this.$v.weightage.required) {
                errors.push('Weightage is required.')
            }

            if (!this.$v.weightage.decimal) {
                errors.push('Weightage should be numeric.')
            }

            if (!this.$v.weightage.maxValue || !this.$v.weightage.minValue) {
                errors.push('Weightage should be in percentage between 0 to 100.')
            }

            return errors
        },

    },
    created() {
        this.getActivityGroups();

    }
}
</script>
