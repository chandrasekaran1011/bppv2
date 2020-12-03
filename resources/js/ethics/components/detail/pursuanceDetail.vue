<template>
<div>
    
    <div class="title grad text-left pa-3 ">Entity Head Pursuance</div>
    <table class="tble table-bordered mt-2" style="width:100%">
        <tbody>
            <tr>
                <td colspan="2" style="background-color:#dee2e6;max-width:50%;min-width:50%;width:50%">Assigned to</td>
                <td colspan="2">{{data.pursuance.assigned}}</td>
            </tr>

            <tr v-if="data.status!=11">
                <td colspan="2"  style="background-color:#dee2e6">Proceed with Ethics Commitee?</td>
                <td colspan="2">{{data.pursuance.decision}}</td>
            </tr>

            
            <tr v-if="data.status!=11">
                <td colspan="2" style="background-color:#dee2e6">Reason for pursuance</td>
                <td colspan="2"><p style="white-space:pre-wrap;">{{data.pursuance.reason}}</p></td>
            </tr>

            <tr v-if="data.status!=11">
                <td colspan="2" style="background-color:#dee2e6">Approval By</td>
                <td colspan="2">{{data.pursuance.by}} ({{data.pursuance.at}})</td>
            </tr>
        </tbody>
    </table>
</div>
</template>

<script>
export default {
    props:{
        data: {
            required: true,
            type: Object
        }
    }
}
</script>
