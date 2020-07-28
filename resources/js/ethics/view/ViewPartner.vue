<template>
<div>
    <div class="display-1 text-left mb-2">
        View Business Partners
    </div>

    <v-divider>

    </v-divider>

    <v-row>
        <v-col cols="12" :sm="12" class="pa-0" :md="4" :offset-md="8">
            <v-text-field v-model="search" placeholder="Search in results"></v-text-field>
        </v-col>
    </v-row>

    <v-skeleton-loader v-if="dataLoading" ref="skeleton" :boilerplate="true" :type="'table'" class="mx-auto"></v-skeleton-loader>

    <v-data-table v-else :headers="headers" :search="search" :items="partnerList" :items-per-page="10" class="elevation-1">
        <template v-slot:item.action="{ item }">
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
        dataLoading:false,
        search: '',
        partnerList: [],
        headers: [
            {
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
            this.dataLoading=true;
            axios.post(window.links.view, formData).then(response => {
               console.log(response.data);
               this.partnerList=response.data;
            }).catch(
                (error) => {
                    console.log(" Error Fetching Data");
                }
            ).then(()=>{
                this.dataLoading=false;
            })
        },
        partnerDetail(id){
            console.log(id);
            this.$router.push({name:'Detail',params:{id:id}});
        }
    },
    created(){
        this.viewPartner();
    }
}
</script>
