<template>
<div>

    <v-row class="mt-lg-6 pt-lg-6">
        <v-col cols="12" :sm="12">
            <v-row :justify="'space-around'">
                <v-col :md="4" cols="12">
                    <v-card @click="nav(7);" style="cursor:pointer;background-color: #a4508b;background-image: linear-gradient(326deg, #a4508b 0%, #5f0a87 74%);" class="mx-auto" max-width="300px">
                        <v-icon class="pa-3 mt-3 white--text" :size="64">fas fa-chart-line</v-icon>
                        <v-card-text class="title white--text">
                            Dashboard
                        </v-card-text>
                    </v-card>
                </v-col>

                <v-col :md="4" cols="12" v-if="$can('Create Partner')">
                    <v-card @click="dialog=true;" style="cursor:pointer;background-color: #3bb78f;background-image: linear-gradient(315deg, #3bb78f 0%, #0bab64 74%);" class="mx-auto" max-width="300px">
                        <v-icon class="pa-3 mt-3 white--text" :size="64">fas fa-plus</v-icon>
                        <v-card-text class="title white--text" >
                            Create Business Partner
                        </v-card-text>
                    </v-card>
                </v-col>

                <v-col :md="4" cols="12" v-if="$can('View Partner')">
                    <v-card @click="nav(2);" style="cursor:pointer;background-color: #f9484a;background-image: linear-gradient(315deg, #f9484a 0%, #fbd72b 74%);" class="mx-auto" max-width="300px">
                        <v-icon class="pa-3 mt-3 white--text" :size="64">fas fa-users</v-icon>
                        <v-card-text class="title white--text">
                            View Partner
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>
        </v-col>
        <v-col class="d-sm-none d-md-block">
            <img src="/images/systra.jpg" width="250px" height="75px" alt="img">
            <div class="title">Business Partner Portal</div>
        </v-col>

        <v-col cols="12" :sm="12">
            <v-row :justify="'space-around'">

                <v-col :md="4" cols="12">

                    <v-card @click="nav(5)" style="cursor:pointer;background-color: #7f53ac;background-image: linear-gradient(315deg, #7f53ac 0%, #647dee 74%);color:white" class="mx-auto" max-width="300px">
                        <v-icon class="pa-3 mt-3 white--text" :size="64">fas fa-check</v-icon>
                        <v-card-text class="title white--text">
                            Pending Approvals
                        </v-card-text>
                    </v-card>

                </v-col>

                <v-col :md="4" cols="12">
                    <v-card @click="nav(6);" style="cursor:pointer;background-color: #bf3a30;background-image: linear-gradient(315deg, #bf3a30 0%, #864ba2 74%);" class="mx-auto" max-width="300px">
                        <v-icon class="pa-3 mt-3 white--text" :size="64">fas fa-file-alt</v-icon>
                        <v-card-text class="title white--text">
                            Reports
                        </v-card-text>
                    </v-card>
                </v-col>

                <v-col :md="4" cols="12">
                    <v-card @click="nav(4);" style="cursor:pointer;background-color: #4dccc6;background-image: linear-gradient(315deg, #4dccc6 0%, #96e4df 74%);" class="mx-auto" max-width="300px">
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
            <v-card-title class="headline indigo white--text lighten-2">
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
