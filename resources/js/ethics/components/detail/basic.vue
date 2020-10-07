<template>
<div>
    <div class="title grad text-left pa-3 ">Basic Details</div>
    <table class="tble table-bordered mt-2" v-if="data.type.value!=8" style="width:100%">
        <tbody>
            <tr>
                <td colspan="2" style="background-color:#dee2e6;max-width:50%;min-width:50%;width:50%">Name of Organisation</td>
                <td colspan="2">{{data.name}}</td>
            </tr>


            <tr v-if="data.status>1">
                <td colspan="2" style="background-color:#dee2e6">Organisational Type</td>
                <td colspan="2">{{data.org_type}}</td>
            </tr>

            <tr v-if="data.status>1">
                <td colspan="2" style="background-color:#dee2e6">Registered address</td>
                <td colspan="2">{{data.address}}</td>
            </tr>

             <tr  v-if="data.status>1">
                <td colspan="2" style="background-color:#dee2e6">Incorporation Number</td>
                <td colspan="2">{{data.cop_num}} <span class="ml-3" v-if="data.files.incorp_file!==''"><a :href="data.files.incorp_file" target="_blank" style="text-decoration:none"><v-icon>fas fa-paperclip</v-icon></a></span> </td>
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
                <td colspan="2">{{data.stock.yn}}<span v-if="data.stock.value==1">({{data.stock.name}})</span></td>
            </tr>

            <tr  v-if="data.status>1">
                <td colspan="2" style="background-color:#dee2e6">
                    Direct shareholders (Listed : Interest over 10% otherwise over 25%):
                </td>
                <td colspan="2">
                    <span v-if="data.stock.value==1">{{data.stock.detail}}</span>
                    <span v-else>NA</span>
                </td>
            </tr>

            <tr  v-if="data.status>1">
                <td colspan="2" style="background-color:#dee2e6">Names of directors and senior management </td>
                <td colspan="2" style="white-space:pre-wrap">{{data.director}}</td>
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

            <tr  v-if="data.status>1">
                <td colspan="2" style="background-color:#dee2e6">Do you intend to use third parties to perform the services covered by the contract with Systra? If yes do you have evaluated the third party integrity?</td>
                <td colspan="2">{{data.tp}}</td>
            </tr>


        </tbody>
    </table>

    <table class="tble table-bordered mt-2" v-if="data.type.value==8" style="width:100%">
        <tbody>
            <tr>
                <td colspan="2" style="background-color:#dee2e6;max-width:50%;min-width:50%;width:50%">Name</td>
                <td colspan="2">{{data.name}}</td>
            </tr>

            <!-- <tr>
                <td colspan="2" style="background-color:#dee2e6">Position</td>
                <td colspan="2">{{data.type.name}}</td>
            </tr> -->

            <tr>
                <td colspan="2" style="background-color:#dee2e6">Resident address</td>
                <td colspan="2">{{data.address}}</td>
            </tr>

            <tr  v-if="data.status>1">
                <td colspan="2" style="background-color:#dee2e6">Tax Number and/or Business Identification Number</td>
                <td colspan="2">{{data.cop_num}} <span class="ml-3" v-if="data.files.incorp_file!==''"><a :href="data.files.incorp_file" target="_blank" style="text-decoration:none"><v-icon>fas fa-paperclip</v-icon></a></span></td>
            </tr>

            <tr  v-if="data.status>1">
                <td colspan="2" style="background-color:#dee2e6">Date of Birth</td>
                <td colspan="2">{{data.doi}}</td>
            </tr>

            <tr  v-if="data.status>1">
                <td colspan="2" style="background-color:#dee2e6">Jurisdiction of incorporation</td>
                <td colspan="2">{{data.cop_juri}}</td>
            </tr>

            <tr  v-if="data.status>1">
                <td colspan="2" style="background-color:#dee2e6">Do you have the required licenses to work? </td>
                <td colspan="2">{{data.license}}</td>
            </tr>
 
            <tr  v-if="data.status>1">
                <td colspan="2" style="background-color:#dee2e6">Does 20% or more of your anticipated annual revenue come from your business with companies from Systra Group ? </td>
                <td colspan="2">{{data.revenue}}</td>
            </tr>

            <tr  v-if="data.status>1">
                <td colspan="2" style="background-color:#dee2e6">Do you intend to use third parties to perform the services covered by the contract with Systra? If yes do you have evaluated the third party integrity?</td>
                <td colspan="2">{{data.tp}}</td>
            </tr>


        </tbody>
    </table>

</div>
</template>
<style>
    .spacing{
        white-space: pre-wrap;
    }
</style>
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