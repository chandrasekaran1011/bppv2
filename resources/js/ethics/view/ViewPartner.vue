<template>
<div>
    <div class="display-1 text-left mb-2">
        <span v-if="mode==0">View Business Partners</span>
        <span v-if="mode==1">View Expired Partners</span>
        <span v-if="mode==2">View Dedarred Partners</span>
    </div>

    <v-divider>

    </v-divider>

    <v-row no-gutters>
        <v-col :justify-md="'start'" :align="'start'" cols="12" :sm="12" class="pa-0" :md="4">
            <v-btn-toggle class="mt-3" v-model="mode" mandatory>
                <v-btn title="All Partners" color="primary" @click="changeView(0)">
                    <v-icon color="white" >fas fa-users</v-icon>
                </v-btn>
                <v-btn title="Expired Partners" color="warning" @click="changeView(1)">
                    <v-icon color="white">fas fa-calendar-times</v-icon>
                </v-btn>
                <v-btn title="Dedarred Partners" color="error" @click="changeView(2)">
                    <v-icon color="white">fas fa-ban</v-icon>
                </v-btn>


            </v-btn-toggle>
        </v-col>
        <v-col cols="12" :sm="12" class="pa-0" :md="4" :offset-md="4">
            <v-text-field v-model="search" placeholder="Search in results"></v-text-field>
        </v-col>
    </v-row>

    <v-skeleton-loader v-if="dataLoading" ref="skeleton" :boilerplate="true" :type="'table'" class="mx-auto"></v-skeleton-loader>

    <v-data-table v-else :headers="headers" :search="search" :items="partnerList" :items-per-page="10" class="elevation-1">
        <template v-slot:[`item.action`]="{ item }">
            <v-btn fab x-small :color="'success'" class="mr-2" @click="partnerDetail(item.id)">
                <v-icon>fas fa-search</v-icon>
            </v-btn>

        </template>
    </v-data-table>

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
export default {
    data: () => ({
        mode: 0,
        dataLoading: false,
        search: '',
        partnerList: [],
        headers: [{
                text: 'S.no',
                value: 'x',

            },
            {
                text: 'Name',
                value: 'name',

            },
            {
                text: 'Type',
                value: 'type'
            },
            {
                text: 'Status',
                value: 'status'
            },

            {
                text: 'Action',
                value: 'action'
            },
        ]
    }),
    methods: {
        viewPartner() {
            const formData = {};
            formData._token = document.getElementById('csrf').content;
            formData.mode = this.mode;
            this.dataLoading = true;
            axios.post(window.links.view, formData).then(response => {

                this.partnerList = response.data;
            }).catch(
                (error) => {
                    
                   this.$store.commit('snackNotify', {
                    type: 'error',
                    msg: error.response.data.message
                });
                //this.mode=0;
                this.partnerList =[];
                }
            ).then(() => {
                this.dataLoading = false;
            })
        },
        partnerDetail(id) {
            console.log(id);
            this.$router.push({
                name: 'Detail',
                params: {
                    id: id
                }
            });
        },
        changeView(id) {
            console.log(id);
            this.mode = id;
            this.viewPartner();
        }
    },
    created() {
        this.viewPartner();
    }
}
</script>
