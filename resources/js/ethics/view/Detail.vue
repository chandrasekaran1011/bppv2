<template>
<div>
    <v-card class="transparent mx-auto text-right mb-2" width="95%" max-width="1200px" v-if="!loading">
        <v-menu offset-y>
            <template v-slot:activator="{ on, attrs }">
                <v-btn color="#1A237E" dark v-bind="attrs" v-on="on">
                    <v-icon class="mr-2">fas fa-cog</v-icon> Options
                </v-btn>
            </template>

            <v-list>

                <create-arrangement v-if="data.status==4 && $can('Create Arrangements')" :id="data.unique" @reset="getData()"></create-arrangement>

                <v-list-item v-if="data.searches>0 &&  $can('View Search Results')" @click="searchResults()">
                    <v-list-item-title>View Search Results</v-list-item-title>
                </v-list-item>

                <v-list-item v-if="data.audit_trial>0 && $can('View Audit')" @click="auditResults()">
                    <v-list-item-title>View Audit Trial</v-list-item-title>
                </v-list-item>

                <v-list-item v-if="data.status==1" @click="regenerate()">
                    <v-list-item-title>Regenrate Notification</v-list-item-title>
                </v-list-item>

                <v-list-item v-if="data.status>3 && $can('Generate Reports')" @click="generateReport()">
                    <v-list-item-title>Generate Report</v-list-item-title>
                </v-list-item>

                <v-list-item @click="viewFiles()">
                    <v-list-item-title>View/Upload Files</v-list-item-title>
                </v-list-item>

                <v-list-item v-if="data.status==1 && data.pmApprover" @click="nonSubmission()">
                    <v-list-item-title>Initiate Non Submission</v-list-item-title>
                </v-list-item>

                <v-list-item v-if="$can('Edit Data')" @click="editMaster()">
                    <v-list-item-title>Edit Data</v-list-item-title>
                </v-list-item>

                <v-list-item @click="delDialog = true;" v-if="$can('Delete Partner')">
                    <v-list-item-title>Delete Partner</v-list-item-title>
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
            <v-card v-if="data.type.value==1">
                <v-tabs v-model="tab" background-color="transparent" color="basil" grow>
                    <v-tab class="red--text font-weight-bold">

                        <a :href="data.downloadForm" class="mr-3" v-if="data.downloadForm!=null" target="blank" style="text-decoration:none">
                            <v-icon color="primary">fas fa-download</v-icon>
                        </a>
                        Business Partner Form
                    </v-tab>

                    <v-tab v-if="data.is_renew" class="red--text font-weight-bold">

                        Renewal<v-spacer></v-spacer>
                        <a :href="data.downloadRenew" class="mr-3" v-if="data.downloadRenew!=null" target="blank" style="text-decoration:none">
                            <v-icon color="primary">fas fa-download</v-icon>
                        </a>
                    </v-tab>

                    <v-tab v-if="data.arrangements>0" class="red--text font-weight-bold">
                        Arrangements
                    </v-tab>

                </v-tabs>

                <v-tabs-items v-model="tab" v-if="data.type.value==1">
                    <v-tab-item v-if="data.type.value==1">
                        <v-card flat>
                            <v-card-text>

                                <public-detail v-if="data.type.value==1" :data="data"></public-detail>
                            </v-card-text>
                        </v-card>
                    </v-tab-item>
                    <v-tab-item v-if="data.is_renew">
                        <v-card flat>
                            <v-card-text>

                                <renew-pm-detail class="mybreak" :data="data"></renew-pm-detail>

                            </v-card-text>
                        </v-card>
                    </v-tab-item>

                    <v-tab-item v-if="data.arrangements>0">
                        <v-card flat>
                            <v-card-text>

                                <arrangement-detail @reset="getData()" :data="data"></arrangement-detail>
                            </v-card-text>
                        </v-card>
                    </v-tab-item>
                </v-tabs-items>
            </v-card>

            <v-card v-if="data.type.value!=1">
                <v-tabs v-model="tab" background-color="transparent" color="basil" grow>
                    <v-tab class="red--text font-weight-bold">
                        Questionnaire <v-spacer></v-spacer><a :href="data.downloadQues" v-if="data.downloadQues!=null" target="blank" style="text-decoration:none">
                            <v-icon color="primary">fas fa-download</v-icon>
                        </a>
                    </v-tab>
                    <v-tab v-if="data.status>2" class="red--text font-weight-bold">
                        Business Partner Form <v-spacer></v-spacer><a :href="data.downloadForm" v-if="data.downloadForm!=null" target="blank" style="text-decoration:none">
                            <v-icon color="primary">fas fa-download</v-icon>
                        </a>
                    </v-tab>
                    <v-tab v-if="data.is_renew" class="red--text font-weight-bold">

                        Renewal<v-spacer></v-spacer>
                        <a :href="data.downloadRenew" class="mr-3" v-if="data.downloadRenew!=null" target="blank" style="text-decoration:none">
                            <v-icon color="primary">fas fa-download</v-icon>
                        </a>
                    </v-tab>

                    <v-tab v-if="data.arrangements>0" class="red--text font-weight-bold">
                        Arrangements
                    </v-tab>
                </v-tabs>

                <v-tabs-items v-model="tab">
                    <v-tab-item v-if="data.type.value!=1">
                        <v-card flat>
                            <v-card-text>

                                <basic-detail v-if="data.type.value!=1 && data.q_submission" :data="data"></basic-detail>

                                <question-detail class="mybreak" :data="data" v-if="data.type.value!=1 && data.status>1 && data.q_submission"></question-detail>

                                <non-submission :data="data" v-if="!data.q_submission"></non-submission>

                            </v-card-text>
                        </v-card>
                    </v-tab-item>

                    <v-tab-item v-if="data.status>2">
                        <v-card flat>
                            <v-card-text>

                                <pm-detail class="mybreak" v-if="data.status>2 && data.type.value!=1" :data="data"></pm-detail>

                            </v-card-text>
                        </v-card>
                    </v-tab-item>

                    <v-tab-item v-if="data.is_renew">
                        <v-card flat>
                            <v-card-text>

                                <renew-pm-detail class="mybreak" :data="data"></renew-pm-detail>

                            </v-card-text>
                        </v-card>
                    </v-tab-item>

                    <v-tab-item v-if="data.arrangements>0">
                        <v-card flat>
                            <v-card-text>

                                <arrangement-detail @reset="getData()" :data="data"></arrangement-detail>
                            </v-card-text>
                        </v-card>
                    </v-tab-item>

                </v-tabs-items>
            </v-card>

            <!-- <ims-detail class="mybreak" v-if="data.status>3" :data="data"></ims-detail> -->
            <finance-detail :data="data" v-if="data.finance.remark!=null"></finance-detail>

            <pursuance-detail :data="data" v-if="data.pursuance"></pursuance-detail>

            <v-row no-gutters :align="'center'" :justify="'space-between'">
                <v-col v-if="data.pmApprover && data.status==2">
                    <pm-approval class="mybreak" :id="data.unique" @reset="getData()"></pm-approval>
                </v-col>

                <v-col v-if="data.imsApprover && data.status==3">
                    <ims-approval class="mybreak" :data="data" :id="data.unique" @reset="getData()"></ims-approval>
                </v-col>

                <v-col v-if="data.l1Approver || data.l2Approver">
                    <escalation-approval :data="data" :id="data.unique" @reset="getData()"></escalation-approval>
                </v-col>

                <v-col v-if="data.status==11 && data.pursuanceApprover">
                    <pursuance-approval :data="data" :id="data.unique" @reset="getData()"></pursuance-approval>
                </v-col>

                <v-col v-if="data.status==4 && data.canBlacklist">
                    <blacklist-partner :data="data" :id="data.unique" @reset="getData()"></blacklist-partner>
                </v-col>
                
                <v-col v-if="data.status==7 && data.canWhitelist">
                    <whitelist-partner :data="data" :id="data.unique" @reset="getData()"></whitelist-partner>
                </v-col>

                <v-col v-if="data.status==3 && data.financeReviewer && data.finance.remark==null">
                    <finance-approval :data="data" :id="data.unique" @reset="getData()"></finance-approval>
                </v-col>

                <v-col v-if="data.renew_partner">
                    <renewal-initiation :dt="data" :id="data.unique" @reset="getData()"></renewal-initiation>
                </v-col>

                <v-col v-if="data.status==10 && data.renewApprover">
                    <renewal-approval :data="data" :id="data.unique" @reset="getData()"></renewal-approval>
                </v-col>

            </v-row>

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
                <v-row no-gutters>
                    <v-col cols="12" :sm="12" class="pa-2 text-left" :md="4">
                        <v-btn class="mt-4" color="success" @click="updateSearch()">Rerun Search</v-btn>
                    </v-col>
                    <v-col cols="12" :sm="12" class="pa-0" :md="4" :offset-md="4">
                        <v-text-field v-model="findSearchResults" placeholder="Search in results"></v-text-field>
                    </v-col>
                </v-row>
                <v-data-table :search="findSearchResults" :headers="searchTableHeaders" :items="searchData" sort-by="id" class="elevation-1">
                    <template v-slot:[`item.link`]="{ item }">
                        <a :href="item.href" target="_blank" rel="noopener noreferrer">{{item.link}}</a>
                    </template>

                </v-data-table>
            </v-card>
        </v-card>
    </v-dialog>

    <!-- File Uploads -->
    <v-dialog v-model="fileBar" fullscreen hide-overlay transition="dialog-bottom-transition">

        <v-card>
            <v-toolbar dark color="primary">
                <v-btn icon dark @click="fileBar = false">
                    <v-icon>fas fa-times</v-icon>
                </v-btn>
                <v-toolbar-title>View/Upload Files</v-toolbar-title>

            </v-toolbar>

            <file-upload :files="filesData" :partner_id="data.unique" @refresh="viewFiles()"></file-upload>

        </v-card>
    </v-dialog>

    <!-- End of File Upload -->
    <!-- Edit Bar -->
    <v-dialog v-model="editBar" max-width="800" transition="dialog-bottom-transition">

        <v-card>
            <v-toolbar dark color="primary">
                <v-btn icon dark @click="editBar = false">
                    <v-icon>fas fa-times</v-icon>
                </v-btn>
                <v-toolbar-title>Master Edit</v-toolbar-title>

            </v-toolbar>

            <master-edit :data="editData" :partner_id="data.unique" @refresh="getData()"></master-edit>

        </v-card>
    </v-dialog>

    <!-- End of Edit Bar -->

    <!-- Audit Bar -->
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

    <!-- End of Audit Bar -->

    <!-- Delete Dialog -->
        
        <v-dialog v-model="delDialog" max-width="500">
            <v-card>
                <v-card-title class="title">Are you sure to delete this partner?</v-card-title>

  

                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="red darken-1" text @click="deletePartner()">
                        Delete
                    </v-btn>
                    <v-btn color="green darken-1" text @click="delDialog = false">
                        close
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    <!-- End of Delete Dialog -->

</div>
</template>

<script>
import axios from "../axios/axios";
import Basic from '../components/detail/basic'
import CreateArrangement from '../components/CreateArrangementComponent'
import Question from '../components/detail/questionnaire'
import NonSubmission from '../components/detail/nonSubmission'
import FinanceDetail from '../components/detail/financeDetail'
import PursuanceDetail from '../components/detail/pursuanceDetail'
import PmApproval from '../components/detail/pmApproval'
import ImsApproval from '../components/detail/imsApproval'
import PmDetail from '../components/detail/pmDetail'
import ArrangementDetail from '../components/detail/arrangementDetail'
import PmDetailRenew from '../components/detail/pmDetailRenew'
import ImsDetail from '../components/detail/imsDetail'
import HeaderDetail from '../components/detail/headerDetail'
import PublicDetail from '../components/detail/public'
import FinanceApproval from '../components/detail/financeApproval'

import EscalationApproval from '../components/detail/escalationApproval'
import PursuanceApproval from '../components/detail/pursuanceApproval'
import BlacklistPartner from '../components/detail/blacklistPartner'
import WhitelistPartner from '../components/detail/whitelistPartner'

import RenewalInitiation from '../components/detail/renewalInitiation'
import RenewalApproval from '../components/detail/renewalApproval'
import FileUpload from '../components/detail/fileUpload'
import MasterEdit from '../components/detail/masterEdit'

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
        'non-submission': NonSubmission,
        'blacklist-partner': BlacklistPartner,
        'whitelist-partner': WhitelistPartner,
        'finance-approval': FinanceApproval,
        'finance-detail': FinanceDetail,
        'renewal-initiation': RenewalInitiation,
        'renewal-approval': RenewalApproval,
        'renew-pm-detail': PmDetailRenew,
        'create-arrangement': CreateArrangement,
        'arrangement-detail': ArrangementDetail,
        'file-upload': FileUpload,
        'master-edit': MasterEdit,
        'pursuance-approval': PursuanceApproval,
        'pursuance-detail': PursuanceDetail,

    },
    data: () => ({
        tab: 0,
        data: {},
        loading: true,
        delDialog:false,
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
                text: 'Search Date',
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
                text: 'Date',
                value: 'date'
            },

        ],
        fileBar: false,
        filesData: [],
        editBar: false,
        editData: []

    }),
    methods: {
        getData() {
            this.editBar = false;
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
        updateSearch() {

            this.$store.state.loading = true;
            let formData = {};
            formData._token = document.getElementById('csrf').content;
            formData.id = this.$route.params.id;
            axios.post(window.links.googleSearch, formData).then((resp) => {
                this.$store.commit('snackNotify', {
                    type: 'success',
                    msg: 'Search Results will be Updated soon'
                });

            }).catch(() => {
                this.$store.commit('snackNotify', {
                    type: 'error',
                    msg: 'Error Occured'
                });
            }).then(() => {
                this.$store.state.loading = false;

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
        viewFiles() {

            this.$store.state.loading = true;
            let formData = {};
            formData._token = document.getElementById('csrf').content;
            formData.id = this.$route.params.id;
            axios.post(window.links.viewFiles, formData).then((resp) => {
                this.filesData = resp.data;

            }).catch(() => {
                this.$store.commit('snackNotify', {
                    type: 'error',
                    msg: 'Error Fetching Data'
                });
            }).then(() => {
                this.$store.state.loading = false;
                this.fileBar = true;

            })

        },
        editMaster() {
            this.editBar = false;
            this.$store.state.loading = true;
            let formData = {};
            formData._token = document.getElementById('csrf').content;
            formData.id = this.$route.params.id;
            axios.post(window.links.getEdit, formData).then((resp) => {
                this.editData = resp.data;

            }).catch(() => {
                this.$store.commit('snackNotify', {
                    type: 'error',
                    msg: 'Error Fetching Data'
                });
            }).then(() => {
                this.$store.state.loading = false;
                this.editBar = true;

            })

        },
        generateReport() {
            this.$store.state.loading = true;

            let formData = {};
            formData._token = document.getElementById('csrf').content;
            formData.id = this.$route.params.id;

            axios.post(window.links.genrateReport, formData).then((resp) => {
                this.$store.commit('snackNotify', {
                    type: 'success',
                    msg: resp.data.message
                });

            }).catch(() => {
                this.$store.commit('snackNotify', {
                    type: 'error',
                    msg: 'Error in Generating Report'
                });
            }).then(() => {
                this.$store.state.loading = false;
            })
        },
        regenerate() {
            this.$store.state.loading = true;

            let formData = {};
            formData._token = document.getElementById('csrf').content;
            formData.id = this.$route.params.id;

            axios.post(window.links.resendNotification, formData).then((resp) => {
                this.$store.commit('snackNotify', {
                    type: 'success',
                    msg: resp.data.message
                });
                this.getData();

            }).catch(() => {
                this.$store.commit('snackNotify', {
                    type: 'error',
                    msg: 'Error in Notification'
                });
            }).then(() => {
                this.$store.state.loading = false;
            })
        },
        nonSubmission() {
            this.$store.state.loading = true;

            let formData = {};
            formData._token = document.getElementById('csrf').content;
            formData.id = this.$route.params.id;

            axios.post(window.links.questionnaireNotSubmitted, formData).then((resp) => {
                this.$store.commit('snackNotify', {
                    type: 'success',
                    msg: resp.data.message
                });
                this.getData();

            }).catch(() => {
                this.$store.commit('snackNotify', {
                    type: 'error',
                    msg: 'Error in Updating'
                });
            }).then(() => {
                this.$store.state.loading = false;
            })
        },
        deletePartner() {
            this.$store.state.loading = true;

            let formData = {};
            formData._token = document.getElementById('csrf').content;
            formData.id = this.$route.params.id;

            axios.post(window.links.deletePartner, formData).then((resp) => {
                this.$store.commit('snackNotify', {
                    type: 'success',
                    msg: resp.data.message
                });
                this.$router.push({
                    name: 'View'
                });

            }).catch(() => {
                this.$store.commit('snackNotify', {
                    type: 'error',
                    msg: 'Error in Updating'
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
