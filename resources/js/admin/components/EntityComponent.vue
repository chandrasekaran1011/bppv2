<template>
<div>
    <v-container>
        <v-row :align="'start'">
            <v-col cols="12">
                <v-row :align="'start'">
                    <v-col cols="12" :md="12">

                        <div class="font-weight-bold display-1">Manage Entity
                            <div class="float-right">
                                <v-dialog v-model="formdialog" persistent max-width="600px">
                                    <template v-slot:activator="{ on }">
                                        <v-btn class="mx-2 text-right" fab dark color="indigo" @click="refreshData()" v-on="on">
                                            <v-icon dark>fas fa-plus</v-icon>
                                        </v-btn>

                                    </template>
                                    <v-card :disabled="loading" :loading="loading">
                                        <v-progress-linear :active="loading" :indeterminate="true" absolute top color="deep-purple accent-4"></v-progress-linear>
                                        <v-card-title>
                                            <span class="headline">Add Entity</span>
                                        </v-card-title>
                                        <v-card-text>
                                            <v-container>
                                                <v-row :justify="'start'">
                                                    <v-col cols="12" md="12">
                                                        <v-text-field label="Name*" v-model="name" :counter="40" :error-messages="nameErrors" @input="$v.name.$touch()" @blur="$v.name.$touch()" single-line></v-text-field>
                                                    </v-col>
                                                    <v-col cols="12" md="12">
                                                        <v-text-field label="Code*" v-model="code" :error-messages="codeErrors" @input="$v.code.$touch()" @blur="$v.code.$touch()" single-line></v-text-field>
                                                    </v-col>
                                                    <v-col cols="12" md="12" >
                                                        <v-autocomplete class="text-left" :items="countryList" item-text="name" item-value="id" :error-messages="countryErrors" v-model="country" @input="$v.country.$touch()" @blur="$v.country.$touch()" label="Country*"></v-autocomplete>

                                                    </v-col>
                                                </v-row>
                                            </v-container>
                                            <small>*indicates required field</small>
                                        </v-card-text>
                                        <v-card-actions>
                                            <v-spacer></v-spacer>

                                            <v-btn v-if="formMode=='create'" color="blue darken-1" text @click="subform()" :disabled="$v.$invalid">Save</v-btn>
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
                                Entity List
                                <v-spacer></v-spacer>
                                <v-text-field style="min-width:300px;" v-model="search" append-icon="mdi-magnify" label="Search" single-line hide-details></v-text-field>
                            </v-card-title>
                            <v-card-text>
                                <v-data-table :headers="headers" :search="search" :items="projects" class="elevation-1">
                                    <template v-slot:item.action="{ item }">
                                        <v-btn  v-if="item.active" fab x-small :color="'primary'" class="mr-2" @click="editItem(item)">
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

                <v-btn color="green darken-1" text @click="delproject()">
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
    numeric,
    maxLength,

} from 'vuelidate/lib/validators'
export default {
    data() {
        return {

            updateLink: '',
            deleteLink: '',
            countryLink: '',
            projectsLink: '',
            snackbar: false,
            snackColor: '',
            snackText: '',
            deldialog: false,
            formdialog: false,
            loading: false,
            formMode: 'create',
            name: '',
            code: '',
            country: '',
            pid: '',
            search: '',
            countryList: [],
            headers: [{
                    text: 'S.no',
                    align: 'start',
                    sortable: false,
                    value: 'sno',
                },
                {
                    text: 'Project Name',
                    value: 'name'
                },
                {
                    text: 'Code',
                    value: 'code'
                },
                {
                    text: 'Country',
                    value: 'country'
                },
                {
                    text: 'Status',
                    value: 'active',
                    sortable: false,
                },
                {
                    text: 'Action',
                    value: 'action',
                    sortable: false,
                }

            ],
            projects: []
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
            formData.code = this.code;
            formData.country = this.country;

            let url = '';

            if (this.formMode == 'create') {
                url = window.links.storeProject;
            } else {
                url = window.links.updateProject;
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
                    this.getProjects();

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

                }).then(()=>{
                    this.loading = false;
                })

           
        },

        getProjects() {
            this.$store.state.loading = true;
            axios.get(window.links.projectIndex).then((response) => {
                const dt = response.data.projects;

                this.projects = dt;

                this.countryList = response.data.countries;

            }).catch(
                (error) => {
                    console.log("Project Ajax error logged");
                }
            ).then(()=>{
                this.$store.state.loading = false;
            })
        },
        editItem(item) {
            this.name = item.name;
            this.code = item.code;
            this.country = item.cid;
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
            this.code = '';
            this.country = '';
        },
        confirmDel(item) {
            this.pid = item.id;
            this.deldialog = true;
        },
        delproject() {
            
            let url = window.links.deleteProject ;
            let formData={};
            formData.id=this.pid;
            axios.post(url, formData)
                .then(res => {
                    if (res.status == 200) {
                        this.snackText = res.data.message;
                        this.snackColor = 'success';
                        this.snackbar = true;

                    }
                    this.getProjects();

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
        code: {
            required
        },
        country: {
            required,
            numeric
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
        codeErrors() {
            const errors = []
            if (!this.$v.code.$dirty) {
                return errors
            }

            if (!this.$v.code.required) {
                errors.push('Code is required.')
            }

            return errors
        },
        countryErrors() {
            const errors = []
            if (!this.$v.country.$dirty) {
                return errors
            }

            if (!this.$v.country.required) {
                errors.push('Country is required.')
            }

            if (!this.$v.country.numeric) {
                errors.push('Something went wrong.')
            }

            return errors
        }
    },

    created() {
        this.$store.state.loading = false;
        this.getProjects();
        
        
    }
}
</script>
