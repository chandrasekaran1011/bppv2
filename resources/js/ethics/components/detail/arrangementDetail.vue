<template>
<div>

    <v-row no-gutters class="mt-3" :justify="'center'">
        <v-col :md="8" :sm="12" :lg="8" :xl="6" :justify="'center'">
            <v-data-table :headers="headers" item-class="text-center" :items="data.arrangementData" :items-per-page="10" class="elevation-1">
                <template v-slot:[`item.action`]="{ item }">
                    <v-btn fab x-small :color="'success'" class="mr-2" @click="showDetail(item)">
                        <v-icon>fas fa-search</v-icon>
                    </v-btn>

                    <v-btn fab x-small :color="'error'" v-if="$can('Delete Arrangements')" class="mr-2" @click="deleteItem(item)">
                        <v-icon>fas fa-trash</v-icon>
                    </v-btn>

                </template>

            </v-data-table>
        </v-col>
    </v-row>

    <v-dialog v-model="dialog" max-width="800px" transition="dialog-transition">
        <v-card>
            <v-toolbar dark color="primary">

                <v-toolbar-title>Arrangement Detail</v-toolbar-title>
                <v-spacer></v-spacer>
                <v-btn icon dark @click="dialog = false">
                    <v-icon>fas fa-times</v-icon>
                </v-btn>

            </v-toolbar>
            <v-card-text class="mt-2">
                <table class="tble table-bordered mt-2">
                    <tbody>
                        <tr>
                            <td colspan="2" style="text-align: center;font-weight: bolder;">Business Partner Form (PART - A)</td>
                        </tr>
                        <tr>
                            <td style="width:50%">
                                Project
                            </td>
                            <td>
                                {{selected.contract}}
                            </td>
                        </tr>
                        <tr>
                            <td style="width:50%">
                                Scope of work
                            </td>
                            <td class="spacing" style="text-align: left;">
                                <p class="text-justify">{{selected.scope}}</p>
                            </td>
                        </tr>

                        <tr>
                            <td style="width:50%">
                                Project Country
                            </td>
                            <td>
                                {{selected.pcountry}}&nbsp;({{selected.pcpi}})
                            </td>
                        </tr>

                        <tr>
                            <td style="width:50%">
                                Phase
                            </td>
                            <td>
                                {{selected.phase}}
                            </td>
                        </tr>

                        <tr>
                            <td style="width:50%">
                                CDO
                            </td>
                            <td>
                                {{selected.cdo}} <span v-if="selected.cdo_date!=''">({{(selected.cdo_date)}})</span>
                            </td>
                        </tr>

                        <tr>
                            <td style="width:50%">
                                Method of selection of the Business Partner
                            </td>
                            <td>
                                {{selected.mutual}}
                            </td>
                        </tr>

                        <tr>
                            <td style="width:50%">
                                Has the Business Partner been recommended by client?
                            </td>
                            <td>
                                {{selected.recomm}}
                            </td>
                        </tr>

                        <tr>
                            <td style="width:50%">
                                Additional Mitigation Action
                            </td>
                            <td class="spacing" style="text-align: left;">
                                <p class="text-justify">{{selected.remarks}}</p>
                            </td>
                        </tr>

                        <tr>
                            <td style="width:50%">
                                Initiator
                            </td>
                            <td>
                                {{selected.created_by}} ({{selected.created_on}})
                            </td>
                        </tr>

                    </tbody>
                </table>
            </v-card-text>

        </v-card>

    </v-dialog>

    <v-dialog v-model="deldialog" max-width="400">
        <v-card class="pt-3 mt-2" :shaped="true">
            <div class="text-center ">
                <v-icon :color="'error'" :x-large="true">fas fa-exclamation-triangle</v-icon>
            </div>
            <v-card-title class="headline ">
                Are you sure to delete?
            </v-card-title>


            <v-card-actions>
                <v-spacer></v-spacer>

                <v-btn color="red darken-1" text @click="delArrangement()">
                    Yes
                </v-btn>
                <v-btn color="green darken-1" text @click="deldialog = false">
                    No
                </v-btn>

            </v-card-actions>
        </v-card>
    </v-dialog>

</div>
</template>

<script>
import axios from "../../axios/axios";

export default {
    data: () => ({
        dialog: false,
        selected: {},
        deldialog:false,
        headers: [,
            {
                text: 'Project',
                value: 'contract',
                class: 'text-center',

            },
            {
                text: 'Phase',
                value: 'phase',
                class: 'text-center',

            },
            {
                text: 'Country',
                value: 'pcountry',
                class: 'text-center',

            },
            {
                text: 'Created on',
                value: 'created_on',
                class: 'text-center',

            },

            {
                text: 'Action',
                class: 'text-center',

                value: 'action'
            },
        ]

    }),
    props: {
        data: {
            required: true,
            type: Object
        },
    },
    methods: {
        showDetail(item) {
            this.selected = item;
            this.dialog = true;
        },
        deleteItem(item){
            this.selected = item;
            this.deldialog = true;
        },
        delArrangement(){
            this.$store.state.loading = true;
            let formData={};
            formData.id=this.selected.unique;
            axios.post(window.links.arrangementDelete, formData).then((resp) => {
                this.$store.commit('snackNotify', {
                    type: 'error',
                    msg: resp.data.message
                });
            }).catch(() => {
                this.$store.commit('snackNotify', {
                    type: 'error',
                    msg: 'Something went wrong'
                });
            }).then(() => {
                this.$store.state.loading = false;
                this.deldialog = false;
                this.$emit('reset');
            })
        }
    }
}
</script>

<style>
.spacing {
    white-space: pre-wrap;
}
</style>
