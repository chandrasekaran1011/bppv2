<template>
<div>

    <v-row class="mt-lg-6 pt-lg-6">
        <v-col cols="12" :sm="12">
            <v-row :justify="'space-around'">
                <v-col :md="4" cols="12">
                    <v-card @click="nav(7);" style="cursor:pointer;background-color: #a20b38;color:white" class="mx-auto" max-width="300px">
                        <v-icon class="pa-3 mt-3 white--text" :size="64">fas fa-chart-line</v-icon>
                        <v-card-text class="title white--text">
                            Dashboard
                        </v-card-text>
                    </v-card>
                </v-col>

                <v-col :md="4" cols="12" v-if="$can('Create Partner')">
                    <v-card @click="dialog=true;" style="cursor:pointer;background-color: #70368b;color:white" class="mx-auto" max-width="300px">
                        <v-icon class="pa-3 mt-3 white--text" :size="64">fas fa-plus</v-icon>
                        <v-card-text class="title white--text" >
                            Create Business Partner
                        </v-card-text>
                    </v-card>
                </v-col>

                <v-col :md="4" cols="12" v-if="$can('View Partner')">
                    <v-card @click="nav(2);" style="cursor:pointer;background-color: #e18e04;color:white" class="mx-auto" max-width="300px">
                        <v-icon class="pa-3 mt-3 white--text" :size="64">fas fa-users</v-icon>
                        <v-card-text class="title white--text">
                            View Partner
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>
        </v-col>
        <!-- <v-col class="d-sm-none d-md-block">
            <img src="/images/systra.jpg" width="250px" height="75px" alt="img">
            <div class="title">Business Partner Portal</div>
        </v-col> -->

        <v-col cols="12" :sm="12">
            <v-row :justify="'space-around'">

                <v-col :md="4" cols="12">

                    <v-card @click="nav(5)" style="cursor:pointer;background-color: #ea4e1b;color:white" class="mx-auto" max-width="300px">
                        <v-icon class="pa-3 mt-3 white--text" :size="64">fas fa-check</v-icon>
                        <v-card-text class="title white--text">
                            Pending Approvals
                        </v-card-text>
                    </v-card>

                </v-col>

                <v-col :md="4" cols="12">
                    <v-card @click="nav(6);" style="cursor:pointer;background-color: #3d3171;color:white" class="mx-auto" max-width="300px">
                        <v-icon class="pa-3 mt-3 white--text" :size="64">fas fa-file-alt</v-icon>
                        <v-card-text class="title white--text">
                            Reports
                        </v-card-text>
                    </v-card>
                </v-col>

                <v-col :md="4" cols="12">
                    <v-card @click="nav(4);" style="cursor:pointer;background-color: #589eb8;color:white" class="mx-auto" max-width="300px">
                        <v-icon class="pa-3 mt-3 white--text" :size="64">fas fa-search</v-icon>
                        <v-card-text class="title white--text">
                            Search Partner
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>
        </v-col>

    </v-row>

    <v-dialog v-model="dialog" width="500">
        <v-card>
            <v-card-title  style="background-color:#3d3171" class="headline  white--text ">
                Select Partner Type
            </v-card-title>

            <v-card-text class="mt-2">
                <v-select :items="typeList" item-text="name" item-value="id" v-model="type" label="Partner Type"></v-select>
            </v-card-text>

            <v-divider></v-divider>

            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="primary" text @click="nav(1)">
                    Proceed
                </v-btn>
                <v-btn color="error" text @click="dialog = false">
                    Close
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</div>
</template>

<script>
export default {
    data: () => ({
        dialog: false,
        type: '',
        typeList: [],
    }),

    methods: {

        nav(val) {
            if (val == 1) {

                this.$router.push({
                    name: 'CreatePartner',
                    params: {
                        'id': this.type
                    }
                })
            } else if (val == 2) {
                this.$router.push({
                    name: 'View'
                })

            } else if (val == 3) {
                this.$router.push({
                    name: 'RfiApprovals'
                })

            }else if (val == 4) {
                this.$router.push({
                    name: 'SearchPartner'
                })

            }
            else if (val == 5) {
                this.$router.push({
                    name: 'Pending'
                })

            }
            else if(val==6){
                this.$router.push({
                    name: 'ReportIndex'
                })
            }
            else if(val==7){
                this.$router.push({
                    name: 'BPDashboard'
                })
            }

        }
    },
    created() {
        this.$store.state.tabId = 1;
        this.typeList = window.pTypes;
       // console.log(this.$can);
    }
}
</script>
