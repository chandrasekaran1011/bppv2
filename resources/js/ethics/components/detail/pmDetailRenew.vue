<template>
<div>
   

    <table class="tble table-bordered mt-2" style="width:100%">
        <tbody>

            
            <tr>
                <td colspan="4" style="text-align: center;font-weight: bolder;">PART - A</td>
            </tr>

            <tr>
                <td colspan="2" >Position </td>
                <td colspan="2">{{data.type.name}}</td>
            </tr>

            <tr>
                <td colspan="2" style="width:50%">Scope to be performed by Business Partner</td>
                <td colspan="2" style="width:50%;vertical-align: middle;">{{data.renew.scope}}</td>

            </tr>

            <tr>
                <td colspan="2">SYSTRA’s Group Contract concerned</td>
                <td colspan="2" style="vertical-align: middle;">{{data.entity}}</td>

            </tr>

            <tr>
                <td colspan="2">Project Concern</td>
                <td colspan="2" style="vertical-align: middle;">{{data.renew.contract}}&nbsp;(Phase - {{data.phase}})</td>

            </tr>

            <tr>
                <td colspan="2">Project Country (CPI)</td>
                <td colspan="2" style="vertical-align: middle;">{{data.renew.pcountry}}&nbsp; ({{data.renew.pcpi}})</td>

            </tr>

            <tr>
                <td colspan="2">Business Partner Country (CPI)</td>
                <td colspan="2" style="vertical-align: middle;">{{data.country}}&nbsp;({{data.cpi}})</td>

            </tr>

            <tr>
                <td colspan="2">CDO</td>
                <td colspan="2" style="vertical-align: middle;">{{data.renew.cdo.yn}} <span v-if="data.renew.cdo.value">, {{data.renew.cdo.date}}</span> </td>

            </tr>

            <tr>
                <td colspan="2">Method of selection of the Business Partner</td>
                <td colspan="2" style="vertical-align: middle;">{{data.renew.mutual}}</td>
            </tr>

            <tr>
                <td colspan="2">Has the Business Partner been recommended by a client</td>
                <td colspan="2" style="vertical-align: middle;">{{data.renew.recomm}}</td>
            </tr>

            <tr>
                <td colspan="4" style="text-align: center;font-weight: bolder;">PART - C</td> 
            </tr>

            <tr>
                <td colspan="2" >Has a basic integrity review of the Business Partner by way of an internet search been performed according to the Procedure? </td>
                <td colspan="2" style="vertical-align: middle;">{{data.renew.search}}<span class="ml-3" v-if="!data.files.screenshot_file!==''"><a :href="data.renew.screenshot_file" target="_blank" style="text-decoration:none"><v-icon>fas fa-paperclip</v-icon></a></span></td>
            </tr>

            <tr>
                <td colspan="2" >Did the Business Partner breach one of its anticorruption commitments towards SYSTRA?  </td>
                <td colspan="2" style="vertical-align: middle;">{{data.renew.breach}}</td>
            </tr>

            <tr>
                <td colspan="4" ><strong>Identified Red Flags</strong> <br><span style="white-space:pre-wrap">{{data.renew.flag}}</span> </td>
                
            </tr>
            <tr>
                <td colspan="4" ><strong>Proposed Mitigation Plan</strong> <br><span style="white-space:pre-wrap">{{data.renew.mitigation}}</span> </td>
            </tr>

            <tr>
                <td colspan="2">Approved By: &nbsp; {{data.renew.pm_by}} </td>
                <td colspan="2" style="vertical-align: middle;">Date: &nbsp;{{data.renew.pm_at}}</td>
            </tr>

            <tr v-if="data.renew.ims_by!=null">
                 <td colspan="4" class="text-center" ><strong>FOR USE OF COMPLIANCE OFFICER/MANAGER</strong></td>
            </tr>

            <tr v-if="data.renew.ims_by!=null">
                <td colspan="2" >Name of the Compliance Manager who renewed this Form </td>
                <td colspan="2" style="vertical-align: middle;">{{data.renew.ims_by}}</td>
            </tr>

            <tr v-if="data.renew.ims_by!=null">
                <td colspan="2" >Date</td>
                <td colspan="2" style="vertical-align: middle;">{{data.renew.ims_at}}</td>
            </tr>

            <tr v-if="data.renew.ims_by!=null">
                <td colspan="2" >Decision</td>
                <td colspan="2" style="vertical-align: middle;">{{data.renew.decision}}</td>
            </tr>


            <tr v-if="data.renew.ims_by!=null">
                <td colspan="2" >Reason of this Decision </td>
                <td colspan="2" style="vertical-align: middle;">{{data.renew.reason}}</td>
            </tr>

            <tr v-if="data.renew.condition!=null">
                <td colspan="2" >Condition </td>
                <td colspan="2" style="vertical-align: middle;">{{data.renew.condition}}</td>
            </tr>

            
            <tr  v-if="data.renew.remarks!=null">
                <td colspan="2" >Additional information </td>
                <td colspan="2" style="vertical-align: middle;">{{data.renew.remarks}}</td>
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
