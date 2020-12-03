<template>
<div>
   
    <v-list-item @click="loadData()">
        <v-list-item-title>Create Arrangements</v-list-item-title>
    </v-list-item>

    
    <v-dialog v-model="pmDialog" fullscreen color="white" persistent transition="dialog-bottom-transition">
        <v-card>
            <v-toolbar dark color="primary">
                <v-btn icon dark @click="pmDialog = false">
                    <v-icon>fas fa-times</v-icon>
                </v-btn>
                <v-toolbar-title>Business Partner Form for New Arrangements</v-toolbar-title>

            </v-toolbar>

            <v-card class="mx-auto" color="white" elevation-3 width="100%" max-width="900px" min-width="600px" height="100%" min-height="400px">

                <div class="title grad text-left mt-3 pa-3">Part A</div>

                <v-row :justify="'center'" class="px-4 py-2" no-gutters>
                    <v-col cols="12" :md="6">
                        <div class="title1 text-left reqFields" for="name">Scope to be performed by Business Partner</div>
                    </v-col>
                    <v-col cols="12" :md="6">
                        <v-textarea outlined label="Scope of work" name="scope" id="scope" :error-messages="scopeErrors" @input="$v.scope.$touch()" @blur="$v.scope.$touch()" v-model="scope"></v-textarea>
                    </v-col>
                </v-row>

                <v-row :justify="'center'" class="mt-2  px-4 py-2" no-gutters>
                    <v-col cols="12" :md="6">
                        <div class="title1 text-left reqFields" for="name">CDO</div>
                    </v-col>
                    <v-col cols="12" :md="6">
                        <v-radio-group v-model="cdo" row :error-messages="cdoErrors" @change="$v.cdo.$touch()" @blur="$v.cdo.$touch()">
                            <v-radio label="Yes" value="1"></v-radio>
                            <v-radio label="No" value="0"></v-radio>
                        </v-radio-group>
                        <!-- <v-checkbox v-model="cdo" true-value="1" false-value="0" :error-messages="cdoErrors" @input="$v.cdo.$touch()" @blur="$v.cdo.$touch()" label="Yes" color="success" hide-details></v-checkbox> -->
                    </v-col>
                </v-row>

                <v-row :justify="'center'" v-if="cdo==1" class="mt-2  px-4 py-2" no-gutters>
                    <v-col cols="12" :md="6">
                        <div class="title1 text-left" for="name">CDO Date</div>
                    </v-col>
                    <v-col cols="12" :md="6">
                        <v-menu v-model="datepicker2" :close-on-content-click="false" transition="scale-transition" offset-y max-width="290px" min-width="290px">
                            <template v-slot:activator="{ on, attrs }">
                                <v-text-field v-model="cdo_date" label="CDO Date" :error-messages="cdo_dateErrors" @input="$v.cdo_date.$touch()" @blur="$v.cdo_date.$touch()" placeholder="click to select date" persistent-hint prepend-icon="fa fa-calendar" readonly v-on="on" v-bind="attrs"></v-text-field>
                            </template>
                            <v-date-picker v-model="cdo_date" no-title :min="nowDate" @input="datepicker2 = false"></v-date-picker>
                        </v-menu>
                    </v-col>
                </v-row>

                <v-row :justify="'center'" class="mt-2 px-4 py-2" no-gutters>
                    <v-col cols="12" :md="6">
                        <div class="title1 text-left" for="name">Project/Contract Concern </div>
                    </v-col>
                    <v-col cols="12" :md="6">
                        <v-text-field label="Project Concern" :error-messages="contractErrors" @input="$v.contract.$touch()" @blur="$v.contract.$touch()" name="contract" v-model="contract"></v-text-field>
                    </v-col>
                </v-row>

                <v-row :justify="'center'" class="mt-2 px-4 py-2" no-gutters>
                    <v-col cols="12" :md="6">
                        <div class="title1 text-left mt-2" for="name">Contract phase </div>
                    </v-col>
                    <v-col cols="12" :md="6">

                        <v-select v-model="phase" :items="phaseList" item-text="name" item-value="id" label="Contract Phase" :error-messages="phaseErrors" @input="$v.phase.$touch()" @blur="$v.phase.$touch()"></v-select>
                    </v-col>
                </v-row>

                <v-row :justify="'center'" class="px-4 py-2" no-gutters>
                    <v-col cols="12" :md="6">
                        <div class="title1 text-left reqFields" for="name">Country of Project</div>
                    </v-col>
                    <v-col cols="12" :md="6">
                        <v-autocomplete v-model="projectCountry" :items="data.countryList" item-text="name" :error-messages="projectCountryErrors" @input="$v.projectCountry.$touch()" @blur="$v.projectCountry.$touch()" item-value="unique" label="Country of the Project" placeholder="Start typing to Search" prepend-icon="fas fa-flag"></v-autocomplete>
                    </v-col>
                </v-row>

                <v-row :justify="'center'" class="mt-2  px-4 py-2" no-gutters>
                    <v-col cols="12" :md="6">
                        <div class="title1 text-left reqFields" for="name">Project CPI Score</div>
                    </v-col>
                    <v-col cols="12" :md="6">
                        <v-text-field label="CPI Score" name="pcpi" :error-messages="pcpiErrors" @input="$v.pcpi.$touch()" @blur="$v.pcpi.$touch()" v-model="pcpi"></v-text-field>
                    </v-col>
                </v-row>

                <v-row :justify="'center'" class="mt-2  px-4 py-2" no-gutters>
                    <v-col cols="12" :md="6">
                        <div class="title1 text-left reqFields mt-3" for="name">Method of selection of the Business Partner</div>
                    </v-col>
                    <v-col cols="12" :md="6">
                        <v-radio-group v-model="mutual" :error-messages="mutualErrors" @input="$v.mutual.$touch()" @blur="$v.mutual.$touch()" row>
                            <v-radio label="Mutual Agreement" value="1"></v-radio>
                            <v-radio label="Competiton" value="0"></v-radio>
                        </v-radio-group>
                    </v-col>
                </v-row>

                <v-row :justify="'center'" class="mt-2  px-4 py-2" no-gutters>
                    <v-col cols="12" :md="7">
                        <div class="title1 text-left reqFields mt-3" for="name">Has the Business Partner been recommended by client?</div>
                    </v-col>
                    <v-col cols="12" :md="5">
                        <v-radio-group v-model="recomm" :error-messages="recommErrors" @input="$v.recomm.$touch()" @blur="$v.recomm.$touch()" row>
                            <v-radio label="Yes" color="red" value="1"></v-radio>
                            <v-radio label="No" color="success" value="0"></v-radio>
                        </v-radio-group>
                    </v-col>
                </v-row>

                <v-row :justify="'center'" class="px-4 py-2" no-gutters>
                    <v-col cols="12" :md="6">
                        <div class="title1 text-left reqFields" for="name">Additional mitigation action required</div>
                    </v-col>
                    <v-col cols="12" :md="6">
                        <v-textarea outlined label="Additional Mitigation Action" name="remarks" id="remarks" :error-messages="remarksErrors" @input="$v.remarks.$touch()" @blur="$v.remarks.$touch()" v-model="remarks"></v-textarea>
                    </v-col>
                </v-row>

                

                <v-row :justify="'center'" class="mt-2 mb-4  px-4 py-2" no-gutters>
                    <v-btn :disabled="$v.$invalid" @click="sumform()" color="success">Create Arrangement</v-btn>
                </v-row>

            </v-card>
        </v-card>
    </v-dialog>
</div>
</template>

<script>
import axios from "../axios/axios";
import {
    required,
    integer,
    maxLength,
    requiredIf,
    requiredUnless

} from 'vuelidate/lib/validators';
export default {
    props: {
        id: {
            required: true,
            type: String,
        }
    },
    data: () => ({
        nowDate: new Date().toISOString().slice(0, 10),
        datepicker: false,
        datepicker2: false,
        pmDialog: false,
        dataLoading: false,
        rules: [
            value => !value || value.size < 20000000 || 'File size should be less than 20 MB!',
        ],
        data: {
            approverList: [],
            fin_approverList: [],
            countryList: [],
            flags: [],
            mitigations: [],

        },
        phaseList: [{
                name: 'Bid',
                id: 1
            }, {
                name: 'Project',
                id: 2
            },
            {
                name: 'Miscellaneous',
                id: 3
            }
        ],

        scope: '',
        contract: '',
        phase: '',
        projectCountry: '',
        pcpi: '',

        cdo: '0',
        cdo_date: '',
        mutual: '0',
        recomm: '0',
        remarks:'',

        
    }),
    methods: {
        loadData() {
            if (this.$store.state.loading == true) {
                return;
            }
            this.$store.state.loading = true;
            let formData = {};
            formData._token = document.getElementById('csrf').content;

            axios.post(window.links.getFormData, formData).then((resp) => {
                this.data.countryList = resp.data.country;
            }).catch(() => {
                this.$store.commit('snackNotify', {
                    type: 'error',
                    msg: 'Error Fetching Data'
                });
            }).then(() => {
                this.$store.state.loading = false;
                this.pmDialog = true;
                console.log(this.unique);
            })
        },
        sumform() {

            if (this.$store.state.loading == true) return;

            this.$store.state.loading = true;

            let formData = new FormData();
            formData.append('_token', document.getElementById('csrf').content);
            formData.append('unique', this.id)
            formData.append('scope', this.scope)
            formData.append('contract', this.contract)
            formData.append('phase', this.phase)
            formData.append('pcountry', this.projectCountry)
            formData.append('pcpi', this.pcpi)
            formData.append('cdo', this.cdo)
            formData.append('dcdo', this.cdo_date)
            formData.append('mutual', this.mutual)
            formData.append('recomm', this.recomm)
            formData.append('remarks', this.remarks)
          
            var link=window.links.arrangementStore;
            
            axios.post(link, formData, {
                headers: {
                    "Content-Type": "multipart/form-data"
                }
            }).then((resp) => {
                this.$store.commit('snackNotify', {
                    type: 'success',
                    msg: resp.data.message
                });

            }).catch((err) => {
                let errText = '';
                if (err.response) {
                    console.log(err.response);
                    if (err.response.status == 422) {
                        Object.values(err.response.data.errors).forEach(val => {
                            errText += val + '\n';
                        });
                        this.$store.commit('snackNotify', {
                            type: 'error',
                            msg: errText
                        });
                    } else {
                        console.log(err.response);
                        this.$store.commit('snackNotify', {
                            type: 'error',
                            msg: err.response.data.message
                        });

                    }
                }
            }).then(() => {
                this.$store.state.loading = false;
                this.pmDialog = false;
                this.$emit('reset');
            })

        }
    },

    validations: {
        scope: {
            required
        },
        remarks: {
            required
        },
        contract: {
            required
        },
        phase: {
            required
        },
        projectCountry: {
            required,
            integer
        },
        pcpi: {
            required,
            integer
        },
        cdo: {
            required
        },
        cdo_date: {
            required: requiredIf(function () {
                return this.cdo == '1'
            })
        },
        mutual: {
            required
        },
        recomm: {
            required
        },
        

    },
    computed: {

        scopeErrors() {
            const errors = []
            if (!this.$v.scope.$dirty) {
                return errors
            }

            if (!this.$v.scope.required) {
                errors.push('Scope of work is required.')
            }

            return errors
        },
        
        remarksErrors() {
            const errors = []
            if (!this.$v.remarks.$dirty) {
                return errors
            }

            if (!this.$v.remarks.required) {
                errors.push('Scope of work is required.')
            }

            return errors
        },
        contractErrors() {
            const errors = []
            if (!this.$v.contract.$dirty) {
                return errors
            }

            if (!this.$v.contract.required) {
                errors.push('Contract is required.')
            }
            return errors
        },
        phaseErrors() {
            const errors = []
            if (!this.$v.phase.$dirty) {
                return errors
            }

            if (!this.$v.phase.required) {
                errors.push('Phase is required.')
            }

            return errors
        },
        projectCountryErrors() {
            const errors = []
            if (!this.$v.projectCountry.$dirty) {
                return errors
            }

            if (!this.$v.projectCountry.required) {
                errors.push('Project Country is required.')
            }

            if (!this.$v.projectCountry.integer) {
                errors.push('Something went wrong.')
            }

            return errors
        },
        pcpiErrors() {
            const errors = []
            if (!this.$v.pcpi.$dirty) {
                return errors
            }

            if (!this.$v.pcpi.required) {
                errors.push('Project Country CPI is required.')
            }

            if (!this.$v.pcpi.integer) {
                errors.push('Something went wrong.')
            }

            return errors
        },
        cdoErrors() {
            const errors = []
            if (!this.$v.cdo.$dirty) {
                return errors
            }

            if (!this.$v.cdo.required) {
                errors.push('CDO is required.')
            }
            return errors
        },
        cdo_dateErrors() {
            const errors = []
            if (!this.$v.cdo_date.$dirty) {
                return errors
            }

            if (!this.$v.cdo_date.required) {
                errors.push('CDO Date is required.')
            }
            return errors
        },
        mutualErrors() {
            const errors = []
            if (!this.$v.mutual.$dirty) {
                return errors
            }

            if (!this.$v.mutual.required) {
                errors.push('Field is required.')
            }
            return errors
        },
        recommErrors() {
            const errors = []
            if (!this.$v.recomm.$dirty) {
                return errors
            }

            if (!this.$v.recomm.required) {
                errors.push('Field is required.')
            }
            return errors
        },
       
    },
    watch: {

        projectCountry: function (val) {
            let arr = this.data.countryList;

            arr.forEach((item, index) => {

                if (item.unique == val) {
                    this.pcpi = item.cpi
                }
            })
        },

      
        cdo: function (val) {
            if (val == '0') {
                this.cdo_date = '';
            }
        },

    },

}
</script>

<style lang="scss">
.custom-loader {
    animation: loader 1s infinite;
    display: flex;
}

@-moz-keyframes loader {
    from {
        transform: rotate(0);
    }

    to {
        transform: rotate(360deg);
    }
}

@-webkit-keyframes loader {
    from {
        transform: rotate(0);
    }

    to {
        transform: rotate(360deg);
    }
}

@-o-keyframes loader {
    from {
        transform: rotate(0);
    }

    to {
        transform: rotate(360deg);
    }
}

@keyframes loader {
    from {
        transform: rotate(0);
    }

    to {
        transform: rotate(360deg);
    }
}

.title1 {
    padding-top: 12px;
}
</style>
