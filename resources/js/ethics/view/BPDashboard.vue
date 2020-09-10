<template>
<div>
    <v-row>
        <v-col :md="3" :sm="12">
            <div class="display-1 font"> BPP Dashboard </div>
            <span>Update at : </span>
        </v-col>
        <v-col :md="4" min-width="300" :sm="12" offset-md="4">
            <v-select :min-width="300" :items="projectList" item-text="name" item-value="unique" @change="projectChange()" label="Project List" solo v-model="project" height="30"></v-select>
        </v-col>
    </v-row>

    <v-row>
        <v-col :sm="12" cols="12" :md="3" :lg="3" class="text-center" style="max-height:380x">
            <v-card class="fill-height hgrad" :elevation="4" style="max-height:380x">
                <v-card-title class="  py-sm-2 pb-xs-0 font">

                    <v-icon class="mr-sm-3" color="success">fa-users</v-icon>
                    <span class=" ml-md-2 mt-md-1 py-sm-0 font ">
                        Registered Partners
                    </span>
                </v-card-title>
                <v-divider dark class="mb-sm-1"></v-divider>

                <v-card-text class="mt-md-2 display-2 white--text">
                    {{this.data.total}}
                </v-card-text>

            </v-card>
        </v-col>

        <v-col :sm="12" cols="12" :md="3" :lg="3" class="text-center" style="max-height:380x">
            <v-card class="fill-height hgrad" :elevation="4" style="max-height:380x">
                <v-card-title class="  py-sm-2 pb-xs-0 font">

                    <v-icon class="mr-sm-3" :color="'warning'">fa-clipboard-list</v-icon>
                    <span class=" ml-md-2 mt-md-1 py-sm-0 font ">
                        Pending Registration
                    </span>
                </v-card-title>
                <v-divider dark class="mb-sm-1"></v-divider>

                <v-card-text class="mt-md-2 display-2 white--text">
                    {{this.data.pending}}
                </v-card-text>

            </v-card>
        </v-col>

        <v-col :sm="12" cols="12" :md="3" :lg="3" class="text-center" style="max-height:380x">
            <v-card class="fill-height hgrad" :elevation="4" style="max-height:380x">
                <v-card-title class="  py-sm-2 pb-xs-0 font">

                    <v-icon class="mr-sm-3" color="primary">fa-check-double</v-icon>
                    <span class=" ml-md-2 mt-md-1 py-sm-0 font ">
                        Renewal Pending
                    </span>
                </v-card-title>
                <v-divider dark class="mb-sm-1"></v-divider>

                <v-card-text class="mt-md-2 display-2 white--text">
                    {{this.data.renewal_pending}}
                </v-card-text>

            </v-card>
        </v-col>

        <v-col :sm="12" cols="12" :md="3" :lg="3" class="text-center" style="max-height:380x">
            <v-card class="fill-height hgrad" :elevation="4" style="max-height:380x">
                <v-card-title class="  py-sm-2 pb-xs-0 font">

                    <v-icon class="mr-sm-3" color="error">fa-ban</v-icon>
                    <span class=" ml-md-2 mt-md-1 py-sm-0 font ">
                        Blacklisted Partners
                    </span>
                </v-card-title>
                <v-divider dark class="mb-sm-1"></v-divider>

                <v-card-text class="mt-md-2 display-2 white--text">
                    {{this.data.blacklisted}}
                </v-card-text>

            </v-card>
        </v-col>

    </v-row>

    <v-row no-gutters class="mt-3">
        <v-col>
            <v-data-table :headers="headers" item-class="text-center"  :items="data.statusReport" :items-per-page="10" class="elevation-1"></v-data-table>
        </v-col>
    </v-row>
</div>
</template>

<script>
export default {

    data: () => ({
        dataLoad: true,
        dialog: false,

        projectList: [],
        project: 0,

        data: [],

        dashValues: [],
        updated_at: '',

        headers: [,
            {
                text: 'Name',
                value: 'name',
                class:'text-center',
                

            },
            {
                text: 'Approved',
                value: 'approved',
                class:'text-center',
                align: 'center',
            },
            {
                text: 'Approved with Condition',
                value: 'approvedwithcond',
                class:'text-center',
                align: 'center',
                
            },

            {
                text: 'Declined',
                value: 'declined',
                class:'text-center',
                align: 'center',
            },
            {
                text: 'Total',
                value: 'total',
                class:'text-center',
                align: 'center',
            },
        ]

    }),

    methods: {

        getDashboard() {
            this.$store.state.loading = true;
            const formData = {};

            formData._token = document.getElementById('csrf').content;
            formData.entity = this.project;

            this.$http.post(window.links.getDashboard, formData).then((response) => {
                this.data = response.data;
                

            }).catch(
                (error) => {
                    this.$store.commit('snackNotify', {
                        type: 'error',
                        msg: 'Data Fetching Error'
                    })
                }
            ).then(() => {
                this.$store.state.loading = false;
            })

        },

        projectChange() {
            this.getDashboard();
        },
        getData() {
            this.$store.state.loading = true;
            let formData = {};
            formData._token = document.getElementById('csrf').content;
            formData.id = this.$route.params.id;
            this.$http.post(window.links.getFormData, formData).then((resp) => {
                this.projectList = resp.data.entity;

                this.projectList.push({
                    'unique': 0,
                    'name': 'All'
                });
            }).catch(() => {
                this.$store.commit('snackNotify', {
                    type: 'error',
                    msg: 'Entity Assigning Error'
                });
            }).then(() => {
                this.$store.state.loading = false;
                this.dataLoading = false;
                this.getDashboard();
            })
        }
    },
    created() {
        //this.$store.state.isLoading = true;

        // if (this.$can('View Dashboard')) {
        //     this.getDashboard();
        // } else {
        //     this.$router.push({
        //         name: 'CreateVendor'
        //     })
        // }

        this.getData();

    }

}
</script>

<style scoped>
.header {
    font-size: 16px !important;
    color: white !important;

}

.font {
    font-family: 'Nunito', sans-serif !important;

}

.bgi {
    background-color: #f9f9f9
}

.wgi {
    background-color: #ffffff
}

.rgrad {
    background-color: #f7b42c;
    background-image: linear-gradient(315deg, #f7b42c 0%, #fc575e 74%);
    color: white !important;
}

.hgrad {
    background-color: #a4508b;
    background-image: linear-gradient(326deg, #a4508b 0%, #5f0a87 74%);

    color: white !important;
}

.bgrad {
    background-color: #7f53ac;
    background-image: linear-gradient(315deg, #7f53ac 0%, #647dee 74%);
    color: white !important;
}

.cgrad {
    background-color: #a4508b;
    background-image: linear-gradient(326deg, #a4508b 0%, #000000 74%);
    color: white !important;
}

.itxt {
    font-weight: 400;
    font: Nunito;
    font-size: 2.125;
}

.fcolor {
    color: white !important;
}
</style>

