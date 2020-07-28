<template>
<div>
    <div class="title grad text-left pa-3 ">Basic Information</div>

    <v-row :justify="'center'" class="mt-2 py-2  px-4" no-gutters>
        <v-col cols="12" :md="6">
            <div class="title1 text-left reqFields" for="name">Business Partner Name</div>
        </v-col>
        <v-col cols="12" :md="6">
            <v-text-field label="Business Partner Name" :error-messages="nameErrors" @input="$v.name.$touch()" @blur="$v.name.$touch()" name="name" id="name" v-model="name"></v-text-field>
        </v-col>
    </v-row>

        <v-row :justify="'center'" class="px-4 py-2" no-gutters>
        <v-col cols="12" :md="6">
            <div class="title1 text-left reqFields" for="name">SYSTRA’s Group Contract concerned</div>
        </v-col>
        <v-col cols="12" :md="6">
            <v-autocomplete v-model="entity" :items="data.entityList" item-text="name" item-value="unique" :error-messages="entityErrors" @input="$v.entity.$touch()" @blur="$v.entity.$touch()" label="Entity" placeholder="Start typing to Search"></v-autocomplete>
        </v-col>
    </v-row>

    <v-row :justify="'center'" class=" px-4 py-2" no-gutters>
        <v-col cols="12" :md="6">
            <div class="title1 text-left" for="name">Position</div>
        </v-col>
        <v-col cols="12" :md="6">
            <div class="red--text font-weight-bold">{{data.partnerType}}</div>
        </v-col>
    </v-row>

    <v-row :justify="'center'" class="px-4 py-2" no-gutters>
        <v-col cols="12" :md="6">
            <div class="title1 text-left reqFields" for="name">Business Partner’s Country</div>
        </v-col>
        <v-col cols="12" :md="6">
            <v-autocomplete v-model="partnerCountry" :items="data.countryList" :error-messages="partnerCountryErrors" @input="$v.partnerCountry.$touch()" @blur="$v.partnerCountry.$touch()" item-text="name" item-value="unique" label="Country of the Firm" placeholder="Start typing to Search" prepend-icon="fas fa-flag"></v-autocomplete>
        </v-col>
    </v-row>

    <v-row :justify="'center'" class="  px-4 py-2" no-gutters>
        <v-col cols="12" :md="6">
            <div class="title1 mt-2 text-left reqFields" for="name">Business Partner’s Country Score</div>
        </v-col>
        <v-col cols="12" :md="6">
            <v-text-field label="CPI Score" name="cpi" :error-messages="cpiErrors" @input="$v.cpi.$touch()" @blur="$v.cpi.$touch()" v-model="cpi"></v-text-field>
        </v-col>
    </v-row>

    <v-row :justify="'center'" class="mt-2 py-2  px-4" no-gutters>
        <v-col cols="12" :md="6">
            <div class="title1 text-left reqFields" for="name">Business Partner’s Email Address</div>
        </v-col>
        <v-col cols="12" :md="6">
            <v-text-field label="Partner Email Address" :error-messages="emailErrors" @input="$v.email.$touch()" @blur="$v.email.$touch()" v-model="email"></v-text-field>
        </v-col>
    </v-row>

    <v-row :justify="'center'" class="mt-2 mb-4  px-4 py-2" no-gutters>
        <v-btn :disabled="$v.$invalid" @click="sumform()" color="success">Create Business Partner</v-btn>
    </v-row>

</div>
</template>

<style>
.grad {
    color: white;
    background-color: rgb(222, 51, 20);
    /* background-image: linear-gradient(315deg, rgb(222, 51, 20) 0%, #b91372 74%); */
}

.pad {
    padding-top: 12px;
}

.reqFields::after {
    content: "*";
    color: red;
}

.v-list-item__title {
    text-align: left;
}
</style>

<script>
import axios from "../axios/axios";
import {
    required,
    integer,
    maxLength,
    email

} from 'vuelidate/lib/validators';
export default {
    
    props: {
        data: {
            required: true,
            type: Object
        }
    },
    data: () => ({
        name: '',
        partnerCountry: '',
        cpi: '',
        email: '',
        entity:'',
    }),
    methods:{
        sumform(){
            if (this.$store.state.loading == true) return;
            this.$store.state.loading = true;

            let formData={};


            formData._token= document.getElementById('csrf').content
            formData.type_id= this.$route.params.id
            formData.name= this.name
            formData.email= this.email
            formData.country= this.partnerCountry
            formData.cpi= this.cpi
            formData.project=this.entity;

            axios.post(window.links.storeOtherForm,formData).then((resp) => {
                this.$store.commit('snackNotify', {
                    type: 'success',
                    msg: resp.data.message
                });
                
            }).catch((err) => {
                let errText = '';
                if (err.response) {
                        this.$store.commit('snackNotify', {
                            type: 'error',
                            msg: err.response.data.message
                        });
                        
                    
                }
            }).then(()=>{
                this.$store.state.loading = false;
            })
        }
    },
    validations: {
        name: {
            required
        },
        partnerCountry: {
            required,
            integer
        },
        cpi: {
            required,
            integer
        },
        email: {
            email,
            required
        },
        entity: {
            required
        },

    },
    computed: {
        nameErrors() {
            const errors = []
            if (!this.$v.name.$dirty) {
                return errors
            }

            if (!this.$v.name.required) {
                errors.push('Partner name is required.')
            }

            return errors
        },
                entityErrors() {
            const errors = []
            if (!this.$v.entity.$dirty) {
                return errors
            }

            if (!this.$v.entity.required) {
                errors.push('Entity is required.')
            }

            return errors
        },
        partnerCountryErrors() {
            const errors = []
            if (!this.$v.partnerCountry.$dirty) {
                return errors
            }

            if (!this.$v.partnerCountry.required) {
                errors.push('partner Country is required.')
            }

            if (!this.$v.partnerCountry.integer) {
                errors.push('Something went wrong.')
            }

            return errors
        },
        cpiErrors() {
            const errors = []
            if (!this.$v.cpi.$dirty) {
                return errors
            }

            if (!this.$v.cpi.required) {
                errors.push('Partner Country CPI is required.')
            }

            if (!this.$v.cpi.integer) {
                errors.push('Something went wrong.')
            }

            return errors
        },
        emailErrors() {
            const errors = []
            if (!this.$v.email.$dirty) {
                return errors
            }

            if (!this.$v.email.required) {
                errors.push('Partner email is required.')

            if (!this.$v.email.email) {
                errors.push('Partner email is invalid.')
            }

                return errors
            }

        }

    },
    watch: {
        partnerCountry: function (val) {
            let arr = this.data.countryList;

            arr.forEach((item, index) => {

                if (item.unique == val) {
                    this.cpi = item.cpi
                }
            })
        },
    }

}
</script>
