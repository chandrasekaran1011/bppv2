<template>
<div>

    <v-card :elevation="3" class="pt-1" max-width="800" style="margin:auto;">
        <v-card-title primary-title>
            File Attachments
            <v-row :justify="'end'"  v-if="$can('Upload Files')" class="m-0 mt-3 mr-3">
                <v-dialog v-model="formdialog" max-width="800px">
                    <template v-slot:activator="{ on }">
                        <v-btn :color="'primary'" v-on="on" fab small top right>
                            <v-icon>fas fa-plus</v-icon>
                        </v-btn>
                    </template>
                    <v-card>
                        <v-card-title>
                            <span class="headline">File Upload</span>
                        </v-card-title>

                        <v-card-text>
                            <v-container grid-list-xs>
                                <v-row>
                                    <v-col cols="12" :md="12">
                                        <v-select :items="types" item-text="name" item-value="value" v-model="name" label="File Type"></v-select>
                                    </v-col>
                                    <v-col cols="12" :md="12">
                                        <v-file-input accept="image/png, image/jpeg, image/bmp,application/pdf" placeholder="Upload file" prepend-icon="fas fa-paperclip" v-model="file" label="Upload a file"></v-file-input>
                                    </v-col>
                                    <v-col cols="12" :md="12" :justify="'center'">
                                        <v-btn :color="'primary'" @click="subForm()">Submit</v-btn>
                                    </v-col>
                                </v-row>

                            </v-container>
                        </v-card-text>

                    </v-card>
                </v-dialog>
            </v-row>
        </v-card-title>

        <v-divider></v-divider>

        <v-row class="pa-md-2" :justify="'start'">
            <template v-for="(f,k) in files">
                
                    <v-col cols=12 :md="3" v-if="f.file!=''" :key="k" max-width="200">

                        <a :href="f.file" target="blank" style="cursor:pointer;text-decoration: none;">
                            <v-card>
                                <v-card-title class="display-2 justify-center">
                                    <v-icon x-large :color="'primary'">fas fa-file-pdf</v-icon>

                                </v-card-title>
                                <v-card-text class="text-center">
                                    {{f.name}}
                                </v-card-text>
                            </v-card>
                        </a>

                    </v-col>
                

            </template>

        </v-row>

    </v-card>

</div>
</template>

<script>

import axios from "../../axios/axios";
export default {
    props: {
        partner_id: {
            type: String
        },
        files: {
            type: Object,

            required: true,
        }
    },
    data: () => ({
        formdialog: false,
        name: '',
        file: [],
        types: [{
                name: 'Incorporation_file',
                value: 'incorp_file'
            },
            {
                name: 'Policy Document',
                value: 'policy_file'
            },
            {
                name: 'Annual Statement',
                value: 'statement_file'
            },
            {
                name: 'ISO Certificate',
                value: 'cert_file'
            },
            {
                name: 'Need Validation Document',
                value: 'need_file'
            },
            {
                name: 'Lexis Document',
                value: 'lexis_file'
            },
            {
                name: 'Screnshot File',
                value: 'screenshot_file'
            },
            {
                name: 'Renewal Screnshot File',
                value: 'renew_screenshot_file'
            },
            {
                name: 'Renewal Lexis File',
                value: 'renew_lexis_file'
            }

        ],

    }),
    methods: {
        subForm() {
            if(this.file.length==0){return ;}
            if (this.name !='') {
                let formData = new FormData();
                formData.append('file', this.file);
                formData.append('name', this.name);
                formData.append('id', this.partner_id);

                axios.post(window.links.uploadFile, formData, {
                        headers: {
                            "Content-Type": "multipart/form-data"
                        }
                    }).then(res => {
                        
                        if(res.status==200){
                            console.log(res);
                            this.$emit('refresh');

                            this.formdialog=false;

                            this.file=[];
                            this.name='';

                            this.$store.commit('snackNotify', {
                                type: 'success',
                                msg: 'File Uploaded'
                            })
                        }else{
                            console.log('here it is'+res);
                            this.$store.commit('errorFunction', res);
                        }

 
                    })
                    .catch(err => {
                        console.log('error called');
                        this.$store.commit('errorFunction', err.response);

                    })
            } else {
                this.$store.commit('snackNotify', {
                    type: 'error',
                    msg: 'Fields Missing'
                })
            }

        },

    }
}
</script>
