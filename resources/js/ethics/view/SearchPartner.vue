<template>
<div>
    <v-container max-width="1400px" class="mx-auto">
        <v-card>
            <v-card-title class="indigo darken-1 white--text"  >
                Search Business Partner
            </v-card-title>
            <v-card-text>
                <v-row no-gutters class="mt-2">
                    <v-col cols="12" :sm="12" :md="3" class="pa-2">
                        <v-select :error-messages="entityErrors" @input="$v.entity.$touch()" @blur="$v.entity.$touch()" :items="entityList" v-model="entity" item-text="name" item-value="unique" label="Select Entity" outlined></v-select>

                    </v-col>
                    <v-col cols="12" :sm="12" :md="3" class="pa-2">
                        <v-select :items="searchList" :error-messages="criteriaErrors" @input="$v.criteria.$touch()" @blur="$v.criteria.$touch()" v-model="criteria" item-text="name" item-value="unique" label="Select Criteria" outlined></v-select>
                    </v-col>

                    <v-col cols="12" :sm="12" :md="3" class="pa-2">
                        <v-text-field name="keyword" :error-messages="keywordErrors" @input="$v.keyword.$touch()" @blur="$v.keyword.$touch()" v-model="keyword" label="Search Keyword"></v-text-field>
                    </v-col>
                    <v-col cols="12" :sm="12" align="center" :md="3" class="pa-2">
                        <v-btn class="mt-md-3" @click="search()" color="success">Submit</v-btn>

                    </v-col>
                </v-row>
            </v-card-text>
        </v-card>

        <v-card class="mt-md-3" v-if="!defaultview">
            <v-card-title class="indigo darken-1 white--text"  >
                Search Results
            </v-card-title>

            <v-card-text>
                <v-card-text>

                     <v-skeleton-loader v-if="dataLoading" ref="skeleton" :boilerplate="true" :type="'table'" class="mx-auto"></v-skeleton-loader>

                    <v-data-table v-else  :headers="headers" :items="results" :items-per-page="10" class="elevation-1">
                        <template v-slot:item.action="{ item }">

                            <v-btn v-if="item.detail" fab x-small :color="'success'" class="mr-2" @click="partnerDetail(item.uuid)">
                                
                                <v-icon>fas fa-search</v-icon>
                            </v-btn>

                        </template>
                    </v-data-table>
                </v-card-text>
            </v-card-text>

        </v-card>
    </v-container>

</div>
</template>

<script>
import axios from "../axios/axios"
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
        dataLoading:false,
        defaultview:true,
        searchList: [{
                unique: 1,
                name: 'Business Partner Name'
            },
            {
                unique: 2,
                name: 'Registration Number'
            },
            {
                unique: 3,
                name: 'Incorporation Number'
            }
        ],
        headers: [{
                text: 'S.no',
                value: 'sno',

            },
            {
                text: 'Name',
                value: 'name',

            },
            {
                text: 'Reg ID',
                value: 'reg'
            },
            {
                text: 'Status',
                value: 'status'
            },
            {
                text: 'Created On',
                value: 'created_at'
            },

            {
                text: 'Action',
                value: 'action'
            },
        ],
        results:[],

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
            if(this.dataLoading){return ;}
            this.dataLoading=true;

            let formData = {};
            formData._token = document.getElementById('csrf').content;
            formData.entity = this.entity;
            formData.keyword = this.keyword;
            formData.criteria = this.criteria;

            axios.post(window.links.searchResult, formData)
                .then(res => {
                    this.results=res.data;
                    console.log(this.results)
                })
                .catch(err => {
                    console.error(err);
                }).then(()=>{
                    this.dataLoading=false;
                    this.defaultview=false;
                })

        },
        partnerDetail(id){
           
            this.$router.push({name:'Detail',params:{id:id}});
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
            minLength: minLength(4)
        }

    },
    computed: {
        entityErrors() {
            const errors = []
            if (!this.$v.entity.$dirty) {
                return errors;
            }

            if (!this.$v.entity.required) {
                errors.push('Entity is required.')
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

            if (!this.$v.keyword.minLength) {
                errors.push('Minum 4 characters is required for search.')
            }

            return errors
        },
    }

}
</script>
