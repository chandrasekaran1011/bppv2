<template>
    <div>
        <v-card class="mx-auto mb-4" color="white" elevation-3 width="95%" max-width="1200px" height="100%" min-height="400px">
        <div class="text-left">

            <h1 class="font-weight-bold py-5 my-2 px-3 d-inline-block display-1 text-left basil--text">
            <span >Business Partner Form</span>
            
            </h1>
            <v-spacer></v-spacer>
            <img src="/images/systra.jpg" width="200px" style="position: absolute;right: 10px;top: 25px;" height="50px" alt="img">
        </div>
        <v-divider> </v-divider>
        <basic-detail :data="data" v-if="this.$store.state.loading==false"></basic-detail>
    </v-card>
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

.tble{
    width: 100%;
    max-width: 100%;
    margin-bottom: 1rem;
    background-color: transparent;
}
.table-bordered {
    border: 1px solid #dee2e6;
}

.tble td, .tble th {
    padding: .75rem;
    vertical-align: middle;
    border-top: 1px solid #dee2e6;
    text-align:left;
}

</style>

<script>
import axios from "../axios/axios";
import Basic from '../components/detail/basic'
export default {
    components:{
        'basic-detail':Basic
    },
    data:()=>({
        data:{},
    }),
    methods:{
        getData(){
            this.$store.state.loading=true;
            let formData = {};
            formData._token = document.getElementById('csrf').content;
            formData.id = this.$route.params.id;
                axios.post(window.links.detail,formData).then((resp) => {
                    this.data=resp.data;
                    console.log(resp.data);
            }).catch(() => {
                this.$store.commit('snackNotify', {
                    type: 'error',
                    msg: 'Error Fetching Data'
                });
            }).then(()=>{
                this.$store.state.loading=false;
                
            })
        }
    },
    created(){
        this.getData();
    }
}
</script>