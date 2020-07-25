<template>
<div>
    <div class="title grad text-left pa-3 ">Basic Details</div>
    <table class="tble table-bordered mt-2" style="width:100%">
        <tbody>
            <tr>
                <td colspan="2" style="background-color:#dee2e6;max-width:50%;min-width:50%;width:50%">Name of Organisation</td>
                <td colspan="2">{{data.name}}</td>
            </tr>

            <tr>
                <td colspan="2" style="background-color:#dee2e6">Type of Partner</td>
                <td colspan="2">{{data.type.name}}</td>
            </tr>
                   

            <tr  v-if="data.status>1">
                <td colspan="2" style="background-color:#dee2e6">Incorporation Number</td>
                <td colspan="2">{{data.cop_num}} </td>
            </tr>

            <tr  v-if="data.status>1">
                <td colspan="2" style="background-color:#dee2e6">Date of incorporation</td>
                <td colspan="2">{{data.doi}}</td>
            </tr>

            <tr  v-if="data.status>1">
                <td colspan="2" style="background-color:#dee2e6">Jurisdiction of incorporation</td>
                <td colspan="2">{{data.cop_juri}}</td>
            </tr>

            <tr  v-if="data.status>1">
                <td colspan="2" style="background-color:#dee2e6">Does the organisation listed in stock exchange ? </td>
                <td colspan="2">{{data.stock.yn}},{{data.stock.name}}</td>
            </tr>

            <tr  v-if="data.status>1">
                <td colspan="2" style="background-color:#dee2e6">
                    Direct shareholders (Listed : Interest over 10% otherwise over 25%):
                </td>
                <td colspan="2">{{data.stock.detail}}
                </td>
            </tr>

            <tr  v-if="data.status>1">
                <td colspan="2" style="background-color:#dee2e6">Names of directors and senior management </td>
                <td colspan="2" style="white-space:pre">{{data.director}}</td>
            </tr>

            <tr  v-if="data.status>1">
                <td colspan="2" style="background-color:#dee2e6">Please identify your subsidiaries </td>
                <td colspan="2">{{data.subsidiary}}</td>
            </tr>

            <tr  v-if="data.status>1">
                <td colspan="2" style="background-color:#dee2e6">Number of employees </td>
                <td colspan="2">{{data.employee}} </td>
            </tr>

            <tr  v-if="data.status>1">
                <td colspan="2" style="background-color:#dee2e6">Does 20% or more of your anticipated annual revenue come from your business with companies from Systra Group ? </td>
                <td colspan="2">{{data.revenue}}</td>
            </tr>

            <tr  v-if="data.status>1">
                <td colspan="2" style="background-color:#dee2e6">Is (or was) your organization under insolvency, liquidation or bankruptcy procedure or debt reorganization ? </td>
                <td colspan="2">{{data.insolvency}}</td>
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