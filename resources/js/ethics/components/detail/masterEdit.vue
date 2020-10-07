<template>
<div class="mt-md-4 mb-md-4">

    <v-row no-gutters max-width="500" justify-md="center">
        <v-col cols="12" :md="6" class="pl-md-3">
            <v-autocomplete v-model="field" :items="data.fields" item-text="name" item-value="field" label="Field To Edit" placeholder="Start typing to Search" prepend-icon="fas fa-cog"></v-autocomplete>
        </v-col>
    </v-row>

    <v-row v-if="type==0" no-gutters max-width="500" justify-md="center">
        <v-col cols="12" :md="6" class="pl-md-3">
            <v-textarea outlined v-model="value" name="editVal" label="Edit Value"></v-textarea>
        </v-col>
    </v-row>

    <v-row v-if="type==2" no-gutters max-width="500" justify-md="center">
        <v-col cols="12" :md="6" class="pl-md-3">
            <v-radio-group v-model="value" row>
                <v-radio label="Yes" value="1"></v-radio>
                <v-radio label="No" value="0"></v-radio>

            </v-radio-group>
        </v-col>
    </v-row>

    <v-row v-if="type==1" no-gutters max-width="500" justify-md="center">
        <v-col cols="12" :md="6" class="pl-md-3">
            <v-radio-group v-model="value" row>
                <v-radio label="Yes" value="1"></v-radio>
                <v-radio label="No" value="0"></v-radio>
                <v-radio label="Other" value="2"></v-radio>
            </v-radio-group>
        </v-col>
    </v-row>

    <v-row no-gutters max-width="500" class="mb-md-5" justify-md="center">
        <v-col cols="12" :md="6" class="pl-md-3">
            <v-btn small color="primary" @click="subForm()">Update</v-btn>
        </v-col>
    </v-row>

</div>
</template>

<script>
export default {
    props: {
        partner_id: {
            type: String
        },
        data: {
            type: Object,

            required: true,
        }
    },

    data: () => ({
        field: '',
        value: '',
        type: 0,
        table:'p',
    }),
    watch: {
        field: function (newVal, oldVal) {

            this.value = this.data.values[newVal];

            this.data.fields.forEach(element => {
                if (element.field == newVal) {
                    this.type = element.type;
                    this.table = element.table;
                    if (this.type == 2) {
                        this.value = this.value ? "1" : "0";
                    }
                    if (this.type == 1) {
                        this.value = this.value.toString();
                    }
                }
            });
            console.log(this.value);
        }
    },

    methods: {
        subForm() {

            if (this.field && this.value) {
                let formData = new FormData();
                formData.append('field', this.field);
                formData.append('value', this.value);
                formData.append('table', this.table);
                formData.append('id', this.partner_id);

                this.$http.post(window.links.updatePartner, formData).then(res => {
                        this.$store.commit('snackNotify', {
                            type: 'success',
                            msg: 'Data Updated'
                        })
                            this.field='';
                            this.value= '';
                        this.$emit('refresh');

                    })
                    .catch(err => {
                        this.$store.commit('errorFunction', err);

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
