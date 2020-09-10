<template>
<div>
    
    <div class="title grad text-left pa-3 ">Finance Review</div>
    <table class="tble table-bordered mt-2" style="width:100%">
        <tbody>
            <tr>
                <td colspan="2" style="background-color:#dee2e6;max-width:50%;min-width:50%;width:50%">Remarks</td>
                <td colspan="2">{{data.finance.remark}}</td>
            </tr>

            <tr>
                <td colspan="2" style="background-color:#dee2e6">Reviewed by</td>
                <td colspan="2">{{data.finance.by}} ({{data.finance.on}})</td>
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
