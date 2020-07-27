<template>
    <div>
        <v-dialog v-model="sDialog" fullscreen hide-overlay transition="dialog-bottom-transition">

      <v-card>
        <v-toolbar dark color="primary">
          <v-btn icon dark @click="sDialog = false">
            <v-icon>mdi-close</v-icon>
          </v-btn>
          <v-toolbar-title>Settings</v-toolbar-title>
          <v-spacer></v-spacer>
          <v-toolbar-items>
            <v-btn dark text @click="sDialog = false">Save</v-btn>
          </v-toolbar-items>
        </v-toolbar>
        <h1>Hi</h1>
      </v-card>
    </v-dialog>
    </div>
</template>


<script>
export default {
    props: {
        id: {
            required: true,
            type: String,
        },
        searchDialog:{
            required:true,
            type:Boolean,
            
        }

    },
    data:()=>({
        
    }
    ),
    created(){
        if(this.searchDialog){
            this.sDialog=true
        }
    }
}
</script>