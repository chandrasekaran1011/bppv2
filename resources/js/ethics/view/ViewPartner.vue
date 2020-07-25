<template>
<div>
    <div class="display-1 text-left mb-2">
        View Business Partners
    </div>

    <v-divider>

    </v-divider>

    <v-data-table :headers="headers" :search="search" :items="partnerList" :items-per-page="10" class="elevation-1">
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
            axios.post(window.links.view, formData).then(response => {
               console.log(response.data);
               this.partnerList=response.data;
            }).catch(
                (error) => {
                    console.log(" Error Fetching Data");
                }
            )
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
