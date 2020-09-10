<template>
<div>
    

    <table class="tble table-bordered mt-2" style="width:100%">
        <thead>
            <tr>
                <th colspan="4" class="title grad text-left pa-3" style=" color: white;
    background-color: rgb(222, 51, 20);font-size:24px;padding:16px">Registration Status</th>
            </tr>
        </thead>
        <tbody>


            <tr v-if="data.reg!=null">
                <td  style="width:50%;"><strong>Registration ID</strong> </td>
                <td  style="vertical-align: middle;"> {{data.reg}} </td>
            </tr>

            <tr>
                <td  style="width:50%;"><strong>Registration Status</strong> </td>
                <td  style="vertical-align: middle;"> {{data.status_name}} </td>
            </tr>

            <tr v-if="data.status>3">
                <td  style="width:50%;"><strong>Registration Valid till</strong> </td>
                <td  style="vertical-align: middle;"> {{data.validity}} </td>
            </tr>

            <tr v-if="data.status==7">
                <td  style="width:50%;"><strong>Blacklisted Reason</strong> </td>
                <td  style="vertical-align: middle;"> {{data.blacklistDetail.blacklist_reason}} </td>
            </tr> 
            <tr v-if="data.status==7">
                <td  style="width:50%;"><strong>Blacklisted up to</strong> </td>
                <td  style="vertical-align: middle;">{{data.blacklistDetail.blacklist_till}}  </td>
            </tr>

            <tr v-if="data.status==7">
                <td  style="width:50%;"><strong>Blacklisted By</strong> </td>
                <td  style="vertical-align: middle;"> {{data.blacklistDetail.blacklist_by}} </td>
            </tr>

            <tr v-if="data.status==7">
                <td  style="width:50%;"><strong>Blacklisted On</strong> </td>
                <td  style="vertical-align: middle;">{{data.blacklistDetail.blacklist_on}}</td>
            </tr>


        </tbody>
    </table>

</div>
</template>

<style>
.spacing {
    white-space: pre-wrap;
}
</style>

<script>
export default {
    props: {
        data: {
            required: true,
            type: Object
        }
    }
}
</script>
