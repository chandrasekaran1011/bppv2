<template>
<div>
    <v-container>
        <v-row :align="'start'">
            <v-col cols="12">
                <v-row :align="'start'">
                    <v-col cols="12" :md="12">

                        <div class="font-weight-bold display-1">Manage Contractors
                            <div class="float-right">
                                <v-dialog v-model="formdialog" persistent max-width="600px">
                                    <template v-slot:activator="{ on }">
                                        <v-btn class="mx-2 text-right" fab dark color="indigo" @click="refreshData()" v-on="on">
                                            <v-icon dark>fas fa-plus</v-icon>
                                        </v-btn>

                                    </template>
                                    <v-card>
                                        <v-progress-linear :active="loading" :indeterminate="true" absolute top color="deep-purple accent-4"></v-progress-linear>
                                        <v-card-title>
                                            <span class="headline" v-if="formMode=='create'">Add Contractor</span>
                                            <span class="headline" v-if="formMode=='update'">Add Contractor</span>
                                        </v-card-title>
                                        <v-card-text>
                                            <v-container>
                                                <v-row>
                                                    <v-col cols="12" md="12">
                                                        <v-text-field label="Name*" v-model="name" :counter="40" :error-messages="nameErrors" @input="$v.name.$touch()" @blur="$v.name.$touch()" single-line></v-text-field>
                                                    </v-col>
                                                </v-row>
                                            </v-container>
                                            <small>*indicates required field</small>
                                        </v-card-text>
                                        <v-card-actions>
                                            <v-spacer></v-spacer>

                                            <v-btn v-if="formMode=='create'" color="blue darken-1" text @click="subform()">Save</v-btn>
                                            <v-btn v-if="formMode=='update'" color="blue darken-1" text @click="updateform()">Update</v-btn>
                                            <v-btn color="blue darken-1" text @click="formdialog = false">Close</v-btn>
                                        </v-card-actions>
                                    </v-card>
                                </v-dialog>
                            </div>
                        </div>
                    </v-col>
                </v-row>
                <v-divider class=" d-block"></v-divider>
                <!-- Table -->
                <v-row :align="'start'">
                    <v-col cols="12">
                        <v-card>
                            <v-card-title>
                                Contractor List
                                <v-spacer></v-spacer>
                                <v-text-field style="min-width:300px;" v-model="search" append-icon="mdi-magnify" label="Search" single-line hide-details></v-text-field>
                            </v-card-title>
                            <v-card-text>
                                <v-data-table :headers="headers" :search="search" :items="contractors" :items-per-page="5" class="elevation-1">
                                    <template v-slot:item.action="{ item }">
                                        <v-btn v-if="item.active" fab x-small :color="'primary'" class="mr-2" @click="editItem(item)">
                                            <v-icon>fas fa-pencil-alt</v-icon>
                                        </v-btn>

                                        <v-btn v-if="item.active" fab x-small :color="'error'" class="mr-2" @click="confirmDel(item)">
                                            <v-icon>fas fa-times</v-icon>
                                        </v-btn>

                                     
                                    </template>

                                    <template v-slot:item.active="{ item }">

                                        <v-chip class="ma-2" v-if="!item.active" color="red" text-color="white">
                                            Inactive
                                        </v-chip>

                                        <v-chip class="ma-2" v-if="item.active" color="green" text-color="white">
                                            Active
                                        </v-chip>
                                    </template>

                                </v-data-table>
                            </v-card-text>
                        </v-card>
                    </v-col>
                </v-row>
            </v-col>
        </v-row>
    </v-container>
    <v-snackbar v-model="snackbar" :bottom="true" :color="snackColor" :timeout="5000">
        <span v-html="snackText"></span>
    </v-snackbar>
    <v-dialog v-model="deldialog" max-width="400">
        <v-card class="pt-3" :shaped="true">
            <div class="text-center ">
                <v-icon :color="'error'" :x-large="true">fas fa-exclamation-triangle</v-icon>
            </div>
            <v-card-title class="headline ">

                Are you sure to delete?
            </v-card-title>
            <v-card-text>
                This action can only be reverted by super Admin.
            </v-card-text>

            <v-card-actions>
                <v-spacer></v-spacer>

                <v-btn color="green darken-1" text @click="delContractor()">
                    Agree
                </v-btn>
                <v-btn color="green darken-1" text @click="deldialog = false">
                    Disagree
                </v-btn>

            </v-card-actions>
        </v-card>
    </v-dialog>

</div>
</template>

<script>
import axios from "../axios/axios";
import {
    required,
    maxLength,

} from 'vuelidate/lib/validators'
export default {
    data() {
        return {
            snackbar: false,
            snackColor: '',
            snackText: '',
            deldialog: false,
            formdialog: false,
            loading: false,
            formMode: 'create',
            name: '',
            pid: '',
            search: '',
            headers: [{
                    text: 'S.no',
                    align: 'start',
                    sortable: false,
                    value: 'sno',
                },
                {
                    text: 'Contractor Name',
                    value: 'name'
                },
                {
                    text: 'Status',
                    value: 'active',
                },
                {
                    text: 'Action',
                    value: 'action',
                    sortable: false,
                }

            ],
            contractors: []
        }
    },
    methods: {
        subform(pid = 0) {
            if (this.loading) {
                return;
            }
            this.$v.$reset();
            this.loading = true;
            const formData = {};
            formData._token = document.getElementById('csrf').content;
            formData.name = this.name;


            let url = '';

            if (this.formMode == 'create') {
                url = window.links.storeContractor;
            } else {
                url = window.links.updateContractor;
                formData.id = pid;
            }
            axios.post(url, formData)
                .then(res => {
                    if (res.status == 200) {
                        this.snackText = res.data.message;
                        this.snackColor = 'success';
                        this.snackbar = true;
                        this.formdialog = false
                    }
                    this.getContractors();

                })
                .catch(err => {
                    let errText = '';
                    if (err.response.status = 422) {
                        Object.values(err.response.data.errors).forEach(val => {
                            errText += val + '<br>';
                        });
                        this.snackText = errText;
                        this.snackColor = 'error';
                        this.snackbar = true;
                    } else {
                        console.log(err.response);
                        this.snackText = 'Something went wrong';
                        this.snackColor = 'error';
                        this.snackbar = true;
                        this.formdialog = false
                    }

                })

            this.loading = false;
        },

        getContractors() {
            axios.get(window.links.contractorIndex).then((response) => {
                const dt = response.data.contractor;
                this.contractors = dt;
              

            }).catch(
                (error) => {
                    console.log("Contractor Ajax error logged");
                }
            )
        },
        editItem(item) {
            this.name = item.name;
            this.formMode = 'update';
            this.formdialog = true;
            this.pid = item.id;

        },
        updateform() {
            this.subform(this.pid)
        },
        refreshData() {
            this.formMode = 'create';
            this.name = '';

        },
        confirmDel(item) {
            this.pid = item.id;
            this.deldialog = true;
        },
        delContractor() {
            console.log(this.pid);
            let url = window.links.deleteContractor ;
            let formData={};
            formData.id=this.pid;
            axios.post(url, formData)
                .then(res => {
                    if (res.status == 200) {
                        this.snackText = res.data.message;
                        this.snackColor = 'success';
                        this.snackbar = true;
                    }
                    this.getContractors();
                })
                .catch(err => {
                    console.log(err.response);
                    this.snackText = 'Something went wrong';
                    this.snackColor = 'error';
                    this.snackbar = true;
                })
            this.deldialog = false;

        }

    },
    validations: {
        name: {
            required,
            maxLength: maxLength(40)
        },
    },
    computed: {
        nameErrors() {
            const errors = []
            if (!this.$v.name.$dirty) {
                return errors
            }
            if (!this.$v.name.maxLength) {
                errors.push('Name must be at most 10 characters long')
            }

            if (!this.$v.name.required) {
                errors.push('Name is required.')
            }

            return errors

        },
       
    },

    created() {
        console.log('Contractor Page');
        this.getContractors();
        

    }
}
</script>
