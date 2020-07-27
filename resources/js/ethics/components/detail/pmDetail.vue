<template>
<div>
    <div class="title grad text-left pa-3 ">BID Manager Approval</div>

    <table class="tble table-bordered mt-2" style="width:100%">
        <tbody>

            
            <tr>
                <td colspan="4" style="text-align: center;font-weight: bolder;">PART - A</td>
            </tr>

            <tr>
                <td colspan="2" style="width:70%">Scope</td>
                <td colspan="2" style="width:30%;vertical-align: middle;">{{data.scope}}</td>

            </tr>

            <tr>
                <td colspan="2">SYSTRA’s Group Contract concerned</td>
                <td colspan="2" style="vertical-align: middle;">{{data.entity}}</td>

            </tr>

            <tr>
                <td colspan="2">Project Concern</td>
                <td colspan="2" style="vertical-align: middle;">{{data.contract}}(Phase - {{data.phase}})</td>

            </tr>

            <tr>
                <td colspan="2">Project Country (CPI)</td>
                <td colspan="2" style="vertical-align: middle;">{{data.pcountry}} ({{data.pcpi}})</td>

            </tr>

            <tr>
                <td colspan="2">Business Partner Country (CPI)</td>
                <td colspan="2" style="vertical-align: middle;">{{data.country}}({{data.cpi}})</td>

            </tr>

            <tr>
                <td colspan="2">CDO</td>
                <td colspan="2" style="vertical-align: middle;">{{data.cdo.yn}} <span v-if="data.cdo.value">{{data.cdo.date}}</span> </td>

            </tr>

            <tr>
                <td colspan="2">Method of selection of the Business Partner</td>
                <td colspan="2" style="vertical-align: middle;">{{data.mutual}}</td>
            </tr>

            <tr>
                <td colspan="2">Has the Business Partner been recommended by a client</td>
                <td colspan="2" style="vertical-align: middle;">{{data.recomm}}</td>
            </tr>

            <tr>
                <td colspan="4" style="text-align: center;font-weight: bolder;">PART - B</td> 
            </tr>

            <tr v-if="data.type.value>2">
                <td colspan="2" >Has the need to contract with the Business Partner been validated? </td>
                <td colspan="2" style="vertical-align: middle;">{{data.need}}</td>
            </tr>

            <tr>
                <td colspan="2" >Has a basic integrity review of the Business Partner by way of an internet search been performed according to the Procedure</td>
                <td colspan="2" style="vertical-align: middle;">{{data.search}}</td>
            </tr>

            <tr v-if="data.type.value==1">
                <td colspan="2" >Does the Public Client have policies and a programme to ensure ethical business practices and prevent corruption, such as:</td>
                <td colspan="2" style="vertical-align: middle;">{{data.policy.yn}}</td>

            </tr>

            <tr v-if="data.type.value==1">
                <td colspan="2" style="padding-left:10px">
                    - A code of ethics? <br>
                    - Ethics and compliance training?<br>
                    - A compliance officer?<br>
                    - A “whistleblowing” process?<br>
                    - A policy regarding international sanctions

                </td>
                <td colspan="2">
                    {{data.policy.p1}}<br>
                    {{data.policy.p2}}<br>
                    {{data.policy.p3}}<br>
                    {{data.policy.p4}}<br>
                    {{data.policy.p5}}<br>

                </td>

            </tr>

            <tr v-if="data.type.value==1">
                <td colspan="2" style="padding-left:2rem">
                    Has the Public Client or its Directors been condemned for non-ethical practices or investigation is in progress : 

                </td>
                <td colspan="2">
                    {{data.practice}}
                </td>

            </tr>

            <tr v-if="data.type.value!=1">
                <td colspan="2" >Has the Business Partner a satisfactory ethics program*</td>
                <td colspan="2" style="vertical-align: middle;">{{data.satis}}</td>
            </tr>

            <tr v-if="data.type.value!=1">
                <td colspan="2" >Has the Business Partner or its Principal been condemned for non-ethical practices or current investigation is in progress?:</td>
                <td colspan="2" style="vertical-align: middle;">{{data.practice}}</td>
            </tr>
            <tr>
                <td colspan="4" ><strong>Identified Red Flags</strong> <br><span style="white-space:pre-wrap">{{data.flag}}</span> </td>
                
            </tr>
            <tr>
                <td colspan="4" ><strong>Proposed Mitigation Plan</strong> <br><span style="white-space:pre-wrap">{{data.mitigation}}</span> </td>
                
            </tr>

            <tr>
                <td colspan="2">Approved By: &nbsp; {{data.pm_by}} </td>
                <td colspan="2" style="vertical-align: middle;">Date: &nbsp;{{data.pm_at}}</td>
            </tr>






            </tbody>
    </table>

</div>
</template>

<style>
.spacing {
    white-space: pre;
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
