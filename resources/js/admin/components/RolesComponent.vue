<template>
<div>
    <v-container>
        <v-row :align="'start'">
            <v-col cols="12" :md="12">

                <div class="font-weight-bold display-1">Manage Roles
                    <div class="float-right">
                        <v-dialog v-model="Createdialog" fullscreen hide-overlay transition="dialog-bottom-transition">
                            <template v-slot:activator="{ on }">
                                <v-btn v-on="on" class="mx-2 text-right" @click="createRole()" fab dark color="indigo">
                                    <v-icon dark>fas fa-plus</v-icon>
                                </v-btn>
                            </template>
                            <v-card>
                                <v-toolbar dark color="primary">
                                    <v-btn icon dark @click="Createdialog = false;">
                                        <v-icon>fas fa-times</v-icon>
                                    </v-btn>
                                    <v-toolbar-title>{{dialogTitle}}</v-toolbar-title>
                                    <v-spacer></v-spacer>
                                    <v-toolbar-items>
                                        <v-btn dark text :disabled="$v.$invalid" @click="submitForm()">Save</v-btn>
                                    </v-toolbar-items>
                                </v-toolbar>
                                <v-container style="text-align:start">
                                    <div class="headline">Role Name</div>
                                    <v-row>
                                        <v-col cols="12" :md="6">
                                            <v-text-field v-model="name" :error-messages="nameErrors" :counter="30" label="Role Name*" required @input="$v.name.$touch()" @blur="$v.name.$touch()"></v-text-field>
                                        </v-col>
                                    </v-row>
                                    <div class="headline">Permissions</div>
                                    <v-row>
                                        <v-col cols="12">
                                            <v-alert type="error" :value="true" v-if="checkboxErrors.length>0">
                                                Alteast one permission required
                                            </v-alert>
                                        </v-col>
                                        <v-col cols="12" v-for="(g,gindex) in groupItem" :key="gindex">
                                            <div class="title">{{g.name}}</div>
                                            <v-row>
                                                <v-col cols="12" :md="4" v-for="(p,index) in g.perms" :key="index">
                                                    <v-checkbox v-model="permissions" @change="$v.permissions.$touch()" @blur="$v.permissions.$touch()" :label="p|capitalize" :value="p"></v-checkbox>
                                                </v-col>
                                            </v-row>

                                        </v-col>

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
                        Roles List
                        <v-spacer></v-spacer>
                        <v-text-field v-model="search" append-icon="mdi-magnify" label="Search" single-line hide-details></v-text-field>
                    </v-card-title>
                    <v-card-text>
                        <v-data-table :headers="headers" :search="search" :items="roles" :items-per-page="5" class="elevation-1">
                            <template v-slot:item.action="{ item }">
                                <v-btn fab x-small dark class="mr-2" @click="editRole(item)" color="primary">
                                    <v-icon>
                                        fas fa-pencil-alt
                                    </v-icon>
                                </v-btn>
                                <v-btn fab x-small dark color="error" @click="delDialog = true">
                                    <v-icon>
                                        fas fa-trash
                                    </v-icon>
                                </v-btn>
                            </template>

                        </v-data-table>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>

        <v-dialog v-model="delDialog" max-width="290">
            <v-card>
                <v-card-title class="headline">Deleting a Role?</v-card-title>

                <v-card-text>
                    Deleting a Role is temporarily Disabled
                </v-card-text>

                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="green darken-1" text @click="delDialog = false">
                        close
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

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
    maxLength
} from 'vuelidate/lib/validators'

export default {
    methods: {
        submitForm() {
            var formData = {};
            formData.name = this.name;
            formData.permissions = this.permissions;
            let link = '';
            if (this.mode == 'create') {
                link = window.links.createRole;
            } else {
                link = window.links.updateRole;
                formData.oldName = this.oldName;
            }
 
            axios.post(link, formData)
                .then(() => {
                    this.$store.commit('snackNotify', {
                        type: 'success',
                        msg: 'New Role Updated'
                    });
                    this.Createdialog = false;
                    this.permissions = [];
                    this.name = '';
                    this.$v.$reset();
                    this.getRoles();
                })
                .catch(() => {
                    this.$store.commit('snackNotify', {
                        type: 'error',
                        msg: 'Error Creating New Role'
                    });
                })

        },
        getRoles() {
            this.$store.state.loading = true;
            var formData = {};

            axios.post(window.links.getRoles, formData)
                .then((res) => {
                    this.permissionItem = res.data.permission;
                    this.roles = res.data.roles;
                    this.groupItem = res.data.groups;

                })
                .catch(() => {
                    alert('Something went wrong.Report Admin')
                }).then(()=>{
                    this.$store.state.loading = false;
                })
        },
        createRole() {
            this.name = '';
            this.permissions = [];
            this.dialogTitle = 'Create Role';
            this.mode = 'create'
        },
        editRole(item) {
            console.log(item);
            this.name = item.name;
            this.permissions = item.parray;
            this.dialogTitle = 'Update Role';
            this.mode = 'update';
            this.oldName = item.name;
            this.Createdialog = true;
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
                text: 'Role',
                value: 'name'
            },

            {
                text: 'Number of Users',
                value: 'users'
            },
            {
                text: 'Action',
                value: 'action',
                sortable: false
            }

        ],
        roles: [],
        search: '',

        name: '',
        permissions: [],
        Createdialog: false,
        delDialog:false,

        dialogTitle: 'Create Roles',
        mode: 'create',
        oldName: 'NA',

        permissionItem: [],
        groupItem: [],
    }),
    validations: {
        name: {
            required,
            maxLength: maxLength(30)
        },
        permissions: {
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
        checkboxErrors() {
            const errors = [];
            if (!this.$v.permissions.$dirty) return errors;
            !this.$v.permissions.required && errors.push('Atleast one Permission is required.');
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
        this.$store.state.tabId=1;
        
    }
}
</script>
