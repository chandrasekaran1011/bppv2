<template>
    <div>
         <v-row no-gutters :justify="'space-around'">
             <v-col :md="3" cols="12" class="mx-2">
                 <v-card>
                     <v-card-title primary-title>
                         Total Active Users
                     </v-card-title>
                     <v-card-text class="headline">
                         {{users}}
                     </v-card-text>
                 </v-card>
             </v-col>
             <v-col :md="3" cols="12">
                 <v-card>
                     <v-card-title primary-title>
                         Total Active Roles
                     </v-card-title>
                     <v-card-text class="headline">
                         {{roles}}
                     </v-card-text>
                 </v-card>
             </v-col>
             <v-col :md="3" cols="12">
                 <v-card>
                     <v-card-title primary-title>
                         Entities
                     </v-card-title>
                     <v-card-text class="headline">
                         {{project}}
                     </v-card-text>
                 </v-card>
             </v-col>
         </v-row>
    </div>
</template>

<script>
import axios from "../axios/axios";
export default {
    data() {
        return {
            project:0,
            users:0,
            roles:0
        }
    },
    methods: {
        getDashboard() {
            this.$store.state.loading = true;
            const formData = {};

            formData._token = document.getElementById('csrf').content;

            axios.post(window.links.dashboard, formData).then((response) => {
                
                this.project = response.data.entity;
                this.users=response.data.users;
                this.roles=response.data.roles;

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
    },

    created(){
        this.getDashboard();
    }
}
</script>