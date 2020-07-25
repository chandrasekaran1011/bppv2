<template>
<div>
    <v-row>
        <v-col :md="4" cols="12">
            <v-card @click="dialog=true;" style="cursor:pointer;background-color: #3bb78f;background-image: linear-gradient(315deg, #3bb78f 0%, #0bab64 74%);" class="mx-auto" max-width="300px">
                <v-icon class="pa-3 mt-3 white--text" :size="64">fas fa-plus</v-icon>
                <v-card-text class="title white--text">
                    Create Business Partner
                </v-card-text>
            </v-card>
        </v-col>
        <v-col :md="4" cols="12">
            <v-card @click="nav(2);" style="cursor:pointer;background-color: #f9484a;background-image: linear-gradient(315deg, #f9484a 0%, #fbd72b 74%);" class="mx-auto" max-width="300px">
                <v-icon class="pa-3 mt-3 white--text" :size="64">fas fa-search</v-icon>
                <v-card-text class="title white--text">
                    View Partner
                </v-card-text>
            </v-card>
        </v-col>
        <v-col :md="4" cols="12">
            <v-badge color="success" class="mx-auto" max-width="300px" content="6" overlap>
                <v-card @click="nav(3)" style="cursoe:pointer;background-color: #7f53ac;background-image: linear-gradient(315deg, #7f53ac 0%, #647dee 74%);color:white" min-width="300px" max-width="350px">
                    <v-icon class="pa-3 mt-3 white--text" :size="64">fas fa-check</v-icon>
                    <v-card-text class="title white--text">
                        Pending Approvals
                    </v-card-text>
                </v-card>
            </v-badge>
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
    data:()=>({
        dialog:false,
        type:'',
        typeList:[],
    }),

    methods: {

        nav(val) {
            if (val == 1) {
                
                this.$router.push({
                    name: 'CreatePartner',
                    params:{'id':this.type}
                })
            } else if (val == 2) {
                 this.$router.push({
                    name: 'View'
                })

            } else if (val == 3) {
                this.$router.push({
                    name: 'RfiApprovals'
                })

            }

        }
    },
    created() {
        this.$store.state.tabId = 1;
        this.typeList=window.pTypes;
        console.log(window.pTypes);
    }
}
</script>
