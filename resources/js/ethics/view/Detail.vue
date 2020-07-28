<template>
<div>
    <v-card class="transparent mx-auto text-right mb-2" width="95%" max-width="1200px" v-if="!loading">
        <v-menu offset-y>
            <template v-slot:activator="{ on, attrs }">
                <v-btn color="#1A237E" dark  v-bind="attrs" v-on="on">
                    <v-icon class="mr-2">fas fa-cog</v-icon> Options
                </v-btn>
            </template>

            <v-list>
                <v-list-item v-if="data.searches>0" @click="searchResults()">
                    <v-list-item-title>View Search Results</v-list-item-title>
                </v-list-item>

                <v-list-item v-if="data.audit_trial>0" @click="auditResults()">
                    <v-list-item-title>View Audit Trial</v-list-item-title>
                </v-list-item>

                <v-list-item v-if="data.status==1" @click="regenerate()">
                    <v-list-item-title>Regenrate Notification</v-list-item-title>
                </v-list-item>
            </v-list>
        </v-menu>
    </v-card>
    <v-card id="printableArea" class="mx-auto mb-4" color="white" elevation-3 width="95%" max-width="1200px" height="100%" min-height="400px">

        <div class="text-left">

            <h1 class="font-weight-bold py-5 my-2 px-3 d-inline-block display-1 text-left basil--text">
                <span>Business Partner Form</span>

            </h1>
            <v-spacer></v-spacer>
            <img src="/images/systra.jpg" width="200px" style="position: absolute;right: 10px;top: 25px;" height="50px" alt="img">
        </div>
        <v-divider> </v-divider>
        <div v-if="!loading">
            <header-detail :data="data"></header-detail>

            <public-detail v-if="data.type.value==1" :data="data"></public-detail>

            <v-card v-if="data.type.value!=1">
                <v-tabs v-model="tab" background-color="transparent" color="basil" grow>
                    <v-tab class="red--text font-weight-bold">
                        Questionnaire
                    </v-tab>
                    <v-tab v-if="data.status>2" class="red--text font-weight-bold">
                        Business Partner Form
                    </v-tab>
                </v-tabs>

                <v-tabs-items v-model="tab">
                    <v-tab-item>
                        <v-card flat>
                            <v-card-text>
                                <basic-detail v-if="data.type.value!=1" :data="data"></basic-detail>
                                <question-detail class="mybreak" :data="data" v-if="data.type.value!=1 && data.status>1"></question-detail>
                            </v-card-text>
                        </v-card>
                    </v-tab-item>

                    <v-tab-item>
                        <v-card flat>
                            <v-card-text>
                                
                                <pm-detail class="mybreak" v-if="data.status>2 && data.type.value!=1" :data="data"></pm-detail>

                            </v-card-text>
                        </v-card>
                    </v-tab-item>
                </v-tabs-items>
            </v-card>
            <pm-approval class="mybreak" v-if="data.pmApprover && data.status==2" :id="data.unique" @reset="getData()"></pm-approval>
            <ims-approval class="mybreak" v-if="data.imsApprover && data.status==3" :data="data" :id="data.unique" @reset="getData()"></ims-approval>
            <ims-detail class="mybreak" v-if="data.status>3" :data="data"></ims-detail>
            <escalation-approval v-if="data.l1Approver || data.l2Approver " :data="data" :id="data.unique" @reset="getData()"></escalation-approval>

            

        </div>

    </v-card>

    <v-dialog v-model="searchBar" fullscreen hide-overlay transition="dialog-bottom-transition">

        <v-card>
            <v-toolbar dark color="primary">
                <v-btn icon dark @click="searchBar = false">
                    <v-icon>fas fa-times</v-icon>
                </v-btn>
                <v-toolbar-title>Search Results</v-toolbar-title>
            </v-toolbar>
            <v-card class="mx-auto mt-3 mb-4" color="white" elevation-3 width="95%" max-width="1200px" height="100%" min-height="400px">
                <v-row>
                    <v-col cols="12" :sm="12" class="pa-0" :md="4" :offset-md="8">
                        <v-text-field v-model="findSearchResults" placeholder="Search in results"></v-text-field>
                    </v-col>
                </v-row>
                <v-data-table :search="findSearchResults" :headers="searchTableHeaders" :items="searchData" sort-by="id" class="elevation-1">
                    <template v-slot:item.link="{ item }">
                        <a :href="item.href" target="_blank" rel="noopener noreferrer">{{item.link}}</a>
                    </template>

                </v-data-table>
            </v-card>
        </v-card>
    </v-dialog>

    <v-dialog v-model="auditBar" fullscreen hide-overlay transition="dialog-bottom-transition">

        <v-card>
            <v-toolbar dark color="primary">
                <v-btn icon dark @click="auditBar = false">
                    <v-icon>fas fa-times</v-icon>
                </v-btn>
                <v-toolbar-title>Audit Trial</v-toolbar-title>
            </v-toolbar>
            <v-card class="mx-auto mt-3 mb-4 pa-3" color="white" elevation-3 width="95%" max-width="1200px" height="100%" min-height="400px">
                <v-row>
                    <v-col cols="12" :sm="12" class="pa-0" :md="4" :offset-md="8">
                        <v-text-field v-model="findAuditResults" placeholder="Search in results"></v-text-field>
                    </v-col>
                </v-row>
                <v-data-table :search="findAuditResults" :headers="auditTableHeaders" :items="auditData" sort-by="id" class="elevation-1">

                </v-data-table>
            </v-card>
        </v-card>
    </v-dialog>

</div>
</template>

<style>
.transparent {
    background-color: white !important;
    opacity: 0.65;
    border-color: transparent !important;
    box-shadow: none !important;
}

.grad {
    color: white;
    background-color: rgb(222, 51, 20);
    /* background-image: linear-gradient(315deg, rgb(222, 51, 20) 0%, #b91372 74%); */
}

.pad {
    padding-top: 12px;
}

.reqFields::after {
    content: "*";
    color: red;
}

.v-list-item__title {
    text-align: left;
}

.tble {
    width: 100%;
    max-width: 100%;
    margin-bottom: 1rem;
    background-color: transparent;
}

.table-bordered {
    border: 1px solid #dee2e6;
}

.tble td,
.tble th {
    padding: .75rem;
    vertical-align: middle;
    /* border-top: 1px solid #dee2e6; */
    text-align: left;
    border: 1px solid #dee2e6;
}
</style>

<script>
import axios from "../axios/axios";
import Basic from '../components/detail/basic'
import Question from '../components/detail/questionnaire'
import PmApproval from '../components/detail/pmApproval'
import ImsApproval from '../components/detail/imsApproval'
import PmDetail from '../components/detail/pmDetail'
import ImsDetail from '../components/detail/imsDetail'
import HeaderDetail from '../components/detail/headerDetail'
import PublicDetail from '../components/detail/public'

import EscalationApproval from '../components/detail/escalationApproval'

export default {
    components: {
        'basic-detail': Basic,
        'question-detail': Question,
        'pm-approval': PmApproval,
        'pm-detail': PmDetail,
        'ims-approval': ImsApproval,
        'ims-detail': ImsDetail,
        'header-detail': HeaderDetail,
        'public-detail': PublicDetail,
        'escalation-approval': EscalationApproval,

    },
    data: () => ({
        tab:0,
        data: {},
        loading: true,
        searchBar: false,
        searchData: [],
        findSearchResults: '',
        searchTableHeaders: [{
                text: 'S.no',
                value: 'id',

            },
            {
                text: 'Keyword',
                value: 'kw',

            },
            {
                text: 'Search Result',
                value: 'link'
            },
            {
                text: 'Search Time',
                value: 'date'
            },

        ],
        auditBar: false,
        auditData: [],
        findAuditResults: '',
        auditTableHeaders: [{
                text: 'S.no',
                value: 'id',

            },
            {
                text: 'User',
                value: 'user',

            },
            {
                text: 'Action',
                value: 'action'
            },
            {
                text: 'Date time',
                value: 'date'
            },

        ],

    }),
    methods: {
        getData() {
            this.$store.state.loading = true;
            let formData = {};
            formData._token = document.getElementById('csrf').content;
            formData.id = this.$route.params.id;
            axios.post(window.links.detail, formData).then((resp) => {
                this.data = resp.data;

            }).catch(() => {
                this.$store.commit('snackNotify', {
                    type: 'error',
                    msg: 'Error Fetching Data'
                });
            }).then(() => {
                this.$store.state.loading = false;
                this.loading = false;
                console.log(this.data.audit_trial);

            })
        },
        printDiv(divName) {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;
        },

        searchResults() {

            this.$store.state.loading = true;
            let formData = {};
            formData._token = document.getElementById('csrf').content;
            formData.id = this.$route.params.id;
            axios.post(window.links.searchResults, formData).then((resp) => {
                this.searchData = resp.data;

            }).catch(() => {
                this.$store.commit('snackNotify', {
                    type: 'error',
                    msg: 'Error Fetching Data'
                });
            }).then(() => {
                this.$store.state.loading = false;
                this.searchBar = true;

            })

        },
        auditResults() {

            this.$store.state.loading = true;
            let formData = {};
            formData._token = document.getElementById('csrf').content;
            formData.id = this.$route.params.id;
            axios.post(window.links.auditResults, formData).then((resp) => {
                this.auditData = resp.data;

            }).catch(() => {
                this.$store.commit('snackNotify', {
                    type: 'error',
                    msg: 'Error Fetching Data'
                });
            }).then(() => {
                this.$store.state.loading = false;
                this.auditBar = true;

            })

        },
        regenerate(){
            this.$store.state.loading = true;
            console.log(window.links.resendNotification);

            let formData = {};
            formData._token = document.getElementById('csrf').content;
            formData.id = this.$route.params.id;

            axios.post(window.links.resendNotification,formData).then((resp) => {
                this.$store.commit('snackNotify', {
                    type: 'success',
                    msg: resp.data.message
                });

            }).catch(() => {
                this.$store.commit('snackNotify', {
                    type: 'error',
                    msg: 'Error in Notification'
                });
            }).then(() => {
                this.$store.state.loading = false;
            })
        }

    },
    created() {
        this.getData();
    }
}
</script>
