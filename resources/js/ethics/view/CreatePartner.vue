<template>
<div>
    <v-card class="mx-auto mb-4" color="white" elevation-3 width="95%" max-width="1200px" height="100%" min-height="400px">
        <div>

            <h1 class="font-weight-bold py-5 my-2 d-inline-block display-1 basil--text">
            <img src="/images/systra.jpg" width="150px" style="position: absolute;left: 10px;top: 15px;" height="50px" alt="img">
                <v-spacer></v-spacer>
                <span>Business Partner Form</span>
            </h1>
        </div>
        <v-divider> </v-divider>
        <public-partner-form v-if="!this.$store.state.loading && id==1" :data="data"></public-partner-form>
        <other-partner-form v-if="!this.$store.state.loading && id!=1" :data="data"></other-partner-form>
    </v-card>

    
</div>
</template>

<script>
import axios from "../axios/axios";
import PublicFormComponent from '../components/PublicFormComponent.vue';
import OtherFormComponent from '../components/OtherFormComponent.vue';

import {
    required,
    integer,
    maxLength,

} from 'vuelidate/lib/validators'

export default {
    components:{
        'public-partner-form':PublicFormComponent,
        'other-partner-form':OtherFormComponent,
    },
    data:()=>({
        id:'',
        name:'',
        data:{
            approverList:[],
            countryList:[],
            entityList:[],
            partnerType:'',
            flags:[],
            mitigations:[],
            
        },
        dataLoading:true,
        
    }),

    methods:{
        getData(){
            this.$store.state.loading=true;
            let formData = {};
            formData._token = document.getElementById('csrf').content;
            formData.id = this.$route.params.id;
                axios.post(window.links.getFormData,formData).then((resp) => {
                    this.data.countryList=resp.data.country;
                    this.data.approverList=resp.data.approver;
                    this.data.entityList=resp.data.entity;
                    this.data.partnerType=resp.data.partner.name;
                    this.data.flags=resp.data.flags;
                    this.data.mitigations=resp.data.mitigations;
            }).catch(() => {
                this.$store.commit('snackNotify', {
                    type: 'error',
                    msg: 'Error Fetching Data'
                });
            }).then(()=>{
                this.$store.state.loading=false;
                this.dataLoading=false;
            })
        }
    },
    created(){
        let id=Number(this.$route.params.id);
        this.id=id;
        if(Number.isInteger(id) &&  id<10){
            
            this.getData();
        }
    }
}
</script>
