<template>
<div>
    <v-card class="mx-auto" color="white" elevation-3 width="95%" height="100%" min-height="400px">
        <div>
            <h1 class="font-weight-bold py-3 my-2 d-inline-block display-1 basil--text">
                RFI Approvals
            </h1>
        </div>
        <v-divider> </v-divider>

        <v-row no-gutters>
            <v-col cols="12" :md="4" :sm="12" offset-md="8">
                <v-text-field label="Search RFI" v-model="search" name="name" textarea></v-text-field>
            </v-col>
        </v-row>

        <v-data-table  :headers="headers" :search="search" :items="items" :items-per-page="10" class="elevation-1">

        </v-data-table>

    </v-card>
</div>
</template>
<style>
    .v-data-table-header__icon {
        color: white !important;
    }
   
</style>
<script>
export default {
    data: () => ({
        headers: [{
                text: 'RFI ID',
                value: 'id',
                class: "white--text title  indigo tcolor "
            }, {
                text: 'Contract',
                value: 'contract',
                class: "white--text title indigo"
            },
            {
                text: 'Action',
                value: 'action',
                class: "white--text title  indigo"
            }
        ],
        search: '',
        items: [],
    })
}
</script>
