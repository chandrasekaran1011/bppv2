<template>
<div>
    <v-alert type="error">Questionnaire Not Submitted.</v-alert>

    <div class="title grad text-left pa-3 ">Basic Details</div>
    <table class="tble table-bordered mt-2" style="width:100%">
        <tbody>
            <tr>
                <td colspan="2" style="background-color:#dee2e6;max-width:50%;min-width:50%;width:50%">Partner Name</td>
                <td colspan="2">{{data.name}}</td>
            </tr>

            <tr>
                <td colspan="2" style="background-color:#dee2e6">Position</td>
                <td colspan="2">{{data.type.name}}</td>
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
