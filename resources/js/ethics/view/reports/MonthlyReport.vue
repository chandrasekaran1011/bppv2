<template>
<div>
    <v-container max-width="1400px" class="mx-auto">
        <v-card>
            <v-card-title class="indigo darken-1 white--text">
               <v-btn icon @click="$router.push({name:'ReportIndex'})"><v-icon color="white">fas fa-arrow-left</v-icon> </v-btn> Download Monthly Report
            </v-card-title>
            <v-card-text>
                <v-row no-gutters class="mt-2">
                    <v-col cols="12" :sm="12" :md="3" class="pa-2">
                        <v-select :error-messages="entityErrors" @input="$v.entity.$touch()" @blur="$v.entity.$touch()" :items="entityList" v-model="entity" item-text="name" item-value="unique" label="Select Project" outlined></v-select>

                    </v-col>
                    <v-col cols="12" :sm="12" :md="3" class="pa-2">
                        <v-select :items="searchList" :error-messages="criteriaErrors" @input="$v.criteria.$touch()" @blur="$v.criteria.$touch()" v-model="criteria" item-text="name" item-value="unique" label="Select Criteria" outlined></v-select>
                    </v-col>

                    <v-col cols="12" :sm="12" :md="3" class="pa-2">
                        <v-menu ref="datemenu" v-model="datemenu2" :close-on-content-click="false" transition="scale-transition" offset-y max-width="290px" min-width="290px">
                            <template v-slot:activator="{ on }">
                                <v-text-field v-model="keyword" readonly label="Month" :error-messages="keywordErrors"  @blur="$v.keyword.$touch()" persistent-hint prepend-icon="fas fa-calendar" v-on="on"></v-text-field>
                            </template>
                            <v-date-picker v-model="keyword" landscape type="month" no-title @input="datemenu2 = false"></v-date-picker>
                        </v-menu>

                    </v-col>
                    <v-col cols="12" :sm="12" align="center" :md="3" class="pa-2">
                        <v-btn class="mt-md-3" :disabled="dataLoading || $v.$invalid" @click="search()" color="success">Generate</v-btn>

                    </v-col>
                </v-row>
            </v-card-text>
        </v-card>

        <v-row no-gutters v-if="!dataLoading && results.length>0" class="mt-4" :justify-md="'center'">
            <v-col cols="12" :md="6" class="mx-auto" :justify-md="'center'">
                <a :href="results">
                    <v-btn color="success" class="text-center " height="100px" width="300px">
                        <v-icon dark x-large class="mr-2 mt-n2">fas fa-cloud-download-alt</v-icon> Download Now
                    </v-btn>
                </a>
            </v-col>
        </v-row>

    </v-container>
</div>
</template>

<script>
import axios from "../../axios/axios"
import {
    required,
    minLength
} from 'vuelidate/lib/validators';
export default {
    data: () => ({
        entityList: [{
            unique: 0,
            name: 'All'
        }],
        dataLoading: false,
        defaultview: true,
        searchList: [{
                unique: 1,
                name: 'Registration Initiation Date'
            },
            {
                unique: 2,
                name: 'Registration Complete Date'
            },

        ],
        datemenu2: false,
        results: [],
        entity: '',
        criteria: '',
        keyword: '',
    }),
    methods: {

                getEntityData() {
            let formData = {};
            formData._token = document.getElementById('csrf').content;
            axios.post(window.links.entityData, formData)
                .then(res => {
                    console.log(res.data);
                    var arr = this.entityList.concat(res.data);
                    this.entityList = arr;
                    console.log(this.entityList);
                })
                .catch(err => {
                    console.error(err);
                })
        },
        search() {
            if (this.dataLoading) {
                return;
            }
            this.dataLoading = true;

            let formData = {};
            formData._token = document.getElementById('csrf').content;
            formData.entity = this.entity;
            formData.keyword = this.keyword;
            formData.criteria = this.criteria;

            console.log(formData);
            axios.post(window.links.monthlyReport, formData)
                .then(res => {
                  

                        this.results = res.data.file;
                    
                })
                .catch(err => {
                    this.$store.commit('snackNotify', {
                        type: 'error',
                        msg: 'Something went wrong'
                    });
                }).then(() => {
                    this.dataLoading = false;
                    this.defaultview = false;

                })

        },
        partnerDetail(id) {

            this.$router.push({
                name: 'Detail',
                params: {
                    id: id
                }
            });
        }
    },
    created() {
        this.getEntityData();
    },
    validations: {
        entity: {
            required
        },
        criteria: {
            required
        },
        keyword: {
            required,

        }

    },
    computed: {
        entityErrors() {
            const errors = []
            if (!this.$v.entity.$dirty) {
                return errors;
            }

            if (!this.$v.entity.required) {
                errors.push('Project is required.')
            }

            return errors
        },
        criteriaErrors() {
            const errors = []
            if (!this.$v.criteria.$dirty) {
                return errors;
            }

            if (!this.$v.criteria.required) {
                errors.push('Search Criteria is required.')
            }

            return errors
        },
        keywordErrors() {
            const errors = []
            if (!this.$v.keyword.$dirty) {
                return errors;
            }

            if (!this.$v.keyword.required) {
                errors.push('Field is required.')
            }

            return errors
        },
    }

}
</script>
