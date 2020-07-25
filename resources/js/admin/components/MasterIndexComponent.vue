<template>
<v-container>
    <v-row :align="'start'">
        <v-col cols="12">
            <v-row>
                <v-col>
                    <div class="headline text-left">
                        Hazard log
                    </div>

                </v-col>
            </v-row>
            <v-divider></v-divider>
            <v-row :align="'start'" :justify-md="'space-between'">
                <v-col cols="12" :md="4">
                    <v-hover v-slot:default="{ hover }" open-delay="200">
                        <v-card @click="show(1)" :elevation="hover ? 16 : 2" style="height:100%">
                            <v-card-title>
                                <v-row :justify="'center'">
                                    <v-icon :color="'red darken-1'" :size="72">fas fa-clipboard-list</v-icon>
                                </v-row>
                            </v-card-title>
                            <v-card-title class="red accent-2 white--text">
                                Hazard Category
                            </v-card-title>
                        </v-card>
                    </v-hover>
                </v-col>
                <v-col cols="12" :md="4">
                    <v-hover v-slot:default="{ hover }" open-delay="200">
                        <v-card  @click="show(2)" :elevation="hover ? 16 : 2">
                            <v-card-title :justify="'center'">
                                <v-row :justify="'center'">
                                    <v-icon :color="'red darken-1'" :size="72">fas fa-clipboard-list</v-icon>
                                </v-row>
                            </v-card-title>
                            <v-card-title class="red accent-2 white--text">
                                Hazard Sub-category
                            </v-card-title>
                        </v-card>
                    </v-hover>
                </v-col>
                <v-col cols="12" :md="4">
                    <v-hover  v-slot:default="{ hover }" open-delay="200">
                        <v-card @click="show(3)"  :elevation="hover ? 16 : 2">
                            <v-card-title :justify="'center'">
                                <v-row :justify="'center'">
                                    <v-icon :color="'red darken-1'" :size="72">fas fa-clipboard-list</v-icon>
                                </v-row>
                            </v-card-title>
                            <v-card-title class="red accent-2 white--text">
                                Hazard Type
                            </v-card-title>
                        </v-card>
                    </v-hover>
                </v-col>

            </v-row>
        </v-col>
    </v-row>
</v-container>
</template>

<script>
export default {
    methods:{
        show(n){

            this.$router.push({
                name:"MasterSolo",
                params:{'id':n}
            });

        }
    }
}
</script>
