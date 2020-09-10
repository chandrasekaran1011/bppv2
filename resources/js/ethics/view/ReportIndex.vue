<template>
<div>
    <h1>
        BPP Reports
    </h1>
    <v-row justify="center" no-gutters class="mt-3">
        <v-col cols="12" style="cursor:pointer" sm="12" md="3" class="pa-2">
            <v-card class="pt-3" @click="nav(1)">
                <div justify="center" class="ma-2 text-center red--text display-1">
                    <v-icon color="primary" size="72">fas fa-calendar-alt</v-icon>
                </div>

                <v-card-text class="title">
                    Monthly Report
                </v-card-text>
            </v-card>

        </v-col>

        <v-col cols="12" sm="12" md="3" style="cursor:pointer" class="pa-2">
            <v-card class="pt-3" @click="nav(0)">
                <div justify="center" class="ma-2 text-center red--text display-1">
                    <v-icon color="success" size="72">fas fa-file-alt</v-icon>
                </div>

                <v-card-text class="title">
                    Master Tracker Report
                </v-card-text>
            </v-card>

        </v-col>

        <v-col cols="12" sm="12" style="cursor:pointer" md="3" class="pa-2">
            <v-card class="pt-3">
                <div justify="center" class="ma-2 text-center red--text display-1">
                    <v-icon  color="warning" size="72">fas fa-handshake</v-icon>
                </div>

                <v-card-text class="title">
                    CDO Report
                </v-card-text>
            </v-card>

        </v-col>

    </v-row>
</div>
</template>

<script>
export default {
    methods:{
        nav(id){
            let arr=["MasterReport","MonthlyReport"];

            this.$router.push({name:arr[id]});
        }
    }
}
</script>
