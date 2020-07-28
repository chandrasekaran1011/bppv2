<template>
<div>
    <v-container>
        <v-row :align="'start'">
            <v-col cols="12" :md="12">

                <div class="font-weight-bold display-1">Manage Users
                    <div class="float-right">
                        <v-dialog v-model="Createdialog" fullscreen hide-overlay transition="dialog-bottom-transition">
                            <template v-slot:activator="{ on }">
                                <v-btn v-on="on" class="mx-2 text-right" @click.prevent="createUser()" fab dark color="indigo">
                                    <v-icon dark>fas fa-plus</v-icon>
                                </v-btn>
                            </template>
                            <v-card>
                                <v-toolbar dark color="primary">
                                    <v-btn icon dark @click.prevent="Createdialog = false;">
                                        <v-icon>fas fa-times</v-icon>
                                    </v-btn>
                                    <v-toolbar-title>{{dialogTitle}}</v-toolbar-title>
                                    <v-spacer></v-spacer>
                                    <v-toolbar-items>
                                        <v-btn dark text :disabled="$v.$invalid || $store.state.loading" @click.prevent="submitForm()" >Save</v-btn>
                                    </v-toolbar-items>
                                </v-toolbar>
                                <v-container style="text-align:start">
                                    <validation-errors :errors="validationErrors" v-if="validationErrors!=''"></validation-errors>
                                    <div class="headline">User Creation Form</div>
                                    <v-row>
                                        <v-col cols="12" :md="6">
                                            <v-text-field v-model="name" :error-messages="nameErrors" :counter="30" label="Name*" required @input="$v.name.$touch()" @blur="$v.name.$touch()"></v-text-field>
                                        </v-col>
                                        <v-col cols="12" :md="6">
                                            <v-text-field v-model="email" :error-messages="emailErrors" :counter="30" label="Email*" required @input="$v.email.$touch()" @blur="$v.email.$touch()"></v-text-field>
                                        </v-col>
                                    </v-row>

                                    <v-row justify="center">
                                        <v-expansion-panels>

                                            <v-expansion-panel>
                                                <v-expansion-panel-header><strong>Roles</strong> </v-expansion-panel-header>
                                                <v-expansion-panel-content>
                                                    <v-row>
                                                        <v-col cols="12">
                                                            <v-alert type="error" v-if="assignedRoleErrors.length>0">
                                                                Atleast one Role Need to be Assigned.
                                                            </v-alert>
                                                        </v-col>
                                                    </v-row>
                                                    <v-row>
                                                        <v-col cols="12" :md="4" v-for="(r,index) in roles" :key="index">
                                                            <v-card :elevation="2">
                                                                <div class="pa-md-2" :justify="'center'">
                                                                    <v-switch v-model="assignedRole" :label="r.name" @change="$v.assignedRole.$touch()" @blur="$v.assignedRole.$touch()" :value="r.name"></v-switch>
                                                                </div>

                                                            </v-card>

                                                        </v-col>
                                                    </v-row>
                                                </v-expansion-panel-content>
                                            </v-expansion-panel>
                                            <v-expansion-panel>
                                                <v-expansion-panel-header><strong>Direct Permissions</strong> </v-expansion-panel-header>
                                                <v-expansion-panel-content>
                                                    <v-row>
                                                        <v-col cols="12" :md="12" v-for="(r,index) in groupItem" :key="index">
                                                            <v-card :elevation="2">
                                                                <v-card-title primary-title>
                                                                    {{r.name}}
                                                                </v-card-title>
                                                                <v-card-text>
                                                                    <v-row>
                                                                        <v-col cols="12" :md="4" v-for="(p,pindex) in r.perms" :key="pindex">
                                                                            <v-switch v-model="permissions" :label="p" :value="p"></v-switch>
                                                                        </v-col>
                                                                    </v-row>

                                                                </v-card-text>

                                                            </v-card>

                                                        </v-col>
                                                    </v-row>
                                                </v-expansion-panel-content>
                                            </v-expansion-panel>
                                            <v-expansion-panel>
                                                <v-expansion-panel-header><strong>Assign Entity Access</strong> </v-expansion-panel-header>
                                                <v-expansion-panel-content>
                                                    <v-row :justify="'center'">
                                                        <v-col cols="12" :md="8">
                                                            <v-simple-table fixed-header height="300px">
                                                                <template v-slot:default>
                                                                    <thead>
                                                                        <tr>
                                                                            <th class="text-left">Entity Name</th>
                                                                            <th class="text-left">Access</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr v-for="(r,index) in projectItem" :key="index">
                                                                            <td>{{ r.name }}</td>
                                                                            <td>
                                                                                <v-checkbox v-model="projects" :value="r.unique"></v-checkbox>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </template>
                                                            </v-simple-table>

                                                        </v-col>
                                                    </v-row>
                                                </v-expansion-panel-content>
                                            </v-expansion-panel>

                                        </v-expansion-panels>
                                    </v-row>

                                </v-container>
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
                        Users List
                        <v-spacer></v-spacer>
                        <v-text-field v-model="search" append-icon="mdi-magnify" label="Search" single-line hide-details></v-text-field>
                    </v-card-title>
                    <v-card-text>
                        <v-data-table :headers="headers" :search="search" :items="users" :items-per-page="5" class="elevation-1">
                            <template v-slot:item.action="{ item }">
                                <v-btn fab x-small dark class="mr-2" @click.prevent="editUser(item)" title="Edit User" color="primary">
                                    <v-icon>
                                        fas fa-pencil-alt
                                    </v-icon>
                                </v-btn>
                                <v-btn fab x-small dark color="error" v-if="item.active==1 && item.actPerm " :disabled=" $store.state.loading" @click.prevent="actionUser(item,0)" title="Deactivate User">
                                    <v-icon>
                                        fas fa-user-times
                                    </v-icon>
                                </v-btn>
                                <v-btn fab x-small dark color="success" v-if="item.active==0 " :disabled=" $store.state.loading" @click.prevent="actionUser(item,1)" title="Activate User">
                                    <v-icon>
                                        fas fa-user-check
                                    </v-icon>
                                </v-btn>

                            </template>

                            <template v-slot:item.sno="{ item }">
                                {{users.map(function(x) {return x.name; }).indexOf(item.name) + 1}}
                            </template>

                            <template v-slot:item.active="{ item }">
                                <v-chip class="ma-2" v-if="item.active==1" color="green" text-color="white">
                                    Active
                                </v-chip>
                                <v-chip class="ma-2" v-else color="red" text-color="white">
                                    Inactive
                                </v-chip>

                            </template>

                        </v-data-table>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>

    </v-container>
</div>
</template>

<style>
.v-data-table-header {
    background-color: #3f51b5 !important;

}

.v-data-table-header>tr th {
    font-size: 16px !important;
    color: white !important;
}

.v-data-table-header__icon {
    color: white !important;
}
</style>

<script>
import axios from "../axios/axios";

import {
    required,
    maxLength,
    email
} from 'vuelidate/lib/validators'

export default {
    methods: {
        submitForm() {
            if (this.$store.state.loading == true) return;
            this.$store.state.loading = true;

            var formData = {};
            formData.name = this.name;
            formData.email = this.email;
            formData.permissions = this.permissions;
            formData.assignedRole = this.assignedRole;
            formData.projects = this.projects;

            let link = '';
            let msg = '';
            if (this.mode == 'create') {
                link = window.links.createUser;
                msg = 'New User Created';
            } else {
                link = window.links.updateUser;
                formData.uniqueId = this.editUserId;
                msg = 'User Updated';
            }

            axios.post(link, formData)
                .then(() => {
                    this.$store.commit('snackNotify', {
                        type: 'success',
                        msg: msg
                    });
                    this.Createdialog = false;
                    this.permissions = [];
                    this.name = '';
                    this.email = '';
                    this.editUserId = '';
                    this.assignedRole = [];
                    
                    this.$v.$reset();
                    this.getUser();

                })
                .catch((err) => {
                    if (err.response.status == 422) {
                        this.validationErrors = err.response.data.errors;
                        console.log(this.validationErrors);
                    } else {
                        this.$store.commit('snackNotify', {
                            type: 'error',
                            msg: 'Error Creating User'
                        });
                    }

                }).then(()=>{
                    this.$store.state.loading = false;
                })
            
        },
        getUser() {
            this.$store.state.loading = true;
            var formData = {};
            axios.post(window.links.getUser, formData)
                .then((res) => {
                    this.users = res.data;

                })
                .catch(() => {
                    console.log('Something went wrong with getting Users');
                }).then(()=>{
                    this.$store.state.loading = false;
                })
        },
        getRoles() {
            var formData = {};
            axios.post(window.links.getRoles, formData)
                .then((res) => {
                    this.permissionItem = res.data.permission;
                    this.roles = res.data.roles;
                    this.groupItem = res.data.groups;
                    this.projectItem = res.data.projects;

                })
                .catch(() => {
                    console.log('Something went wrong with getting Roles');
                })
        },
        createUser() {
            this.name = '';
            this.permissions = [];
            this.email = '';
            this.assignedRole = [];
            this.dialogTitle = 'Create New User';
            this.mode = 'create';
            this.validationErrors = '';
            this.projects=[];
        },
        editUser(item) {
            this.name = item.name;
            this.permissions = item.permission;
            this.email = item.email;
            this.assignedRole = item.roles;
            this.dialogTitle = 'Update User';
            this.projects = item.projects;
            this.mode = 'update';
            this.editUserId = item.uniqueId;
            this.Createdialog = true;
            this.validationErrors = '';
        },

        actionUser(item, action) {
            if (this.$store.state.loading == true) return;

            this.$store.state.loading = true;
            let formData = {};
            formData.uniqueId = item.uniqueId;
            formData.action = action;
            console.log(formData);
            let link = window.links.actionUser;

            axios.post(link, formData)
                .then((res) => {
                    this.$store.commit('snackNotify', {
                        type: 'success',
                        msg: res.data
                    });

                    this.getUser();
                })
                .catch(() => {
                    this.$store.commit('snackNotify', {
                        type: 'error',
                        msg: 'Error Updating User'
                    });
                }).then(()=>{
                    this.$store.state.loading = false;
                })

        }
    },
    data: () => ({
        headers: [{
                text: 'S.no',
                align: 'start',
                sortable: false,
                value: 'sno',
            },
            {
                text: 'Name',
                value: 'name'
            },
            {
                text: 'Email',
                value: 'email'
            },
            {
                text: 'Active',
                value: 'active',

            },
            {
                text: 'Action',
                value: 'action',
                sortable: false
            }

        ],
        users: [],
        roles: [],
        search: '',
        validationErrors: '',

        name: '',
        email: '',
        assignedRole: [],
        permissions: [],
        projects: [],

        Createdialog: false,
        delDialog: false,

        dialogTitle: 'Create Users',
        mode: 'create',
        editUserId: 'NA',

        permissionItem: [],
        groupItem: [],
        projectItem: [],

    }),
    validations: {
        name: {
            required,
            maxLength: maxLength(30)
        },
        email: {
            required,
            email
        },
        assignedRole: {
            required
        }

    },
    computed: {
        nameErrors() {
            const errors = [];
            if (!this.$v.name.$dirty) return errors;
            !this.$v.name.maxLength && errors.push('Name must be at most 30 characters long');
            !this.$v.name.required && errors.push('Name is required.');
            return errors
        },
        emailErrors() {
            const errors = [];

            if (!this.$v.email.$dirty) return errors;
            !this.$v.email.email && errors.push('Email is Invalid');
            !this.$v.email.required && errors.push('Email is required.');
            return errors
        },
        assignedRoleErrors() {
            const errors = [];
            if (!this.$v.assignedRole.$dirty) return errors;
            !this.$v.assignedRole.required && errors.push('Atleast one Role is required.');
            return errors
        }
    },
    filters: {
        capitalize: function (str) {
            str = str.split(" ");

            for (var i = 0, x = str.length; i < x; i++) {
                str[i] = str[i][0].toUpperCase() + str[i].substr(1);
            }

            return str.join(" ");
        }
    },
    created() {
        this.$store.state.loading = false;
        this.getRoles();
        this.getUser();
        this.$store.state.tabId = 2;
        
    }
}
</script>
