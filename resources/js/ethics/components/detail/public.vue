<template>
<div>

    <table class="tble table-bordered mt-2"  style="width:100%">
        <tbody>
            <tr>
                <td colspan="4" style="text-align:center;color: white;background-color: rgb(222, 51, 20);">
                    Part A
                </td>
            </tr>
            <tr>
                <td colspan="2" style="max-width:50%;min-width:50%;width:50%">Public Client Name</td>
                <td colspan="2">{{data.name}}</td>
            </tr>

            <tr>
                <td colspan="2" style="">Postion</td>
                <td colspan="2">{{data.type.name}}</td>
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
                <td colspan="2">Project Concern (phase)</td>
                <td colspan="2" style="vertical-align: middle;">{{data.contract}}(Phase - {{data.phase}})</td>
            </tr>

            <tr>
                <td colspan="2">Project's Country Score (CPI)</td>
                <td colspan="2" style="vertical-align: middle;">{{data.pcountry}} ({{data.pcpi}})</td>

            </tr>

            <tr>
                <td colspan="4" style="text-align:center;color: white;background-color: rgb(222, 51, 20);">
                    Part B
                </td>
            </tr>

            <tr>
                <td colspan="2" style="">Registerd Address</td>
                <td colspan="2" class="spacing">{{data.address}}</td>
            </tr>

            <tr>
                <td colspan="2" style="">Incorporation Number</td>
                <td colspan="2">{{data.cop_num}} </td>
            </tr>

            <tr>
                <td colspan="2" style="">Date of incorporation</td>
                <td colspan="2">{{data.doi}}</td>
            </tr>

            <tr>
                <td colspan="2" style="">Jurisdiction of incorporation</td>
                <td colspan="2">{{data.cop_juri}}</td>
            </tr>

            <tr>
                <td colspan="2" style="">Listed in stock exchange ? </td>
                <td colspan="2">{{data.stock.yn}}<span v-if="data.stock.value==1">({{data.stock.name}})</span></td>
            </tr>

            <tr>
                <td colspan="2" style="">
                    Direct Shareholders :
                </td>
                <td colspan="2">
                    <span v-if="data.stock.value==1">{{data.stock.detail}}</span>
                    <span v-else>NA</span>
                </td>
            </tr>

            <tr>
                <td colspan="2" style="">Names of main directors</td>
                <td colspan="2" style="white-space:pre">{{data.director}}</td>
            </tr>

            <tr>
                <td colspan="2" style="">Please identify any main affiliated companies </td>
                <td colspan="2">{{data.subsidiary}}</td>
            </tr>

            <tr>
                <td colspan="2" style="">Number of employees </td>
                <td colspan="2">{{data.employee}} </td>
            </tr>

            <tr>
                <td colspan="2">Has a basic integrity review of the Business Partner by way of an internet search been performed according to the Procedure</td>
                <td colspan="2" style="vertical-align: middle;">{{data.search}} <span class="ml-3" v-if="data.files.screenshot_file!==''"><a :href="data.files.screenshot_file" target="_blank" style="text-decoration:none"><v-icon>fas fa-paperclip</v-icon></a></span></td>
            </tr>

            <tr >
                <td colspan="2">Does the Public Client have policies and a programme to ensure ethical business practices and prevent corruption?</td>
                <td colspan="2" style="vertical-align: middle;">{{data.policy.yn}}<span class="ml-3" v-if="data.files.policy_file!==''"><a :href="data.files.policy_file" target="_blank" style="text-decoration:none"><v-icon>fas fa-paperclip</v-icon></a></span></td>

            </tr>

            <tr >
                <td colspan="2" style="padding-left:10px">
                Does the Policy Include following features.<br>
                    - A code of ethics? <br>
                    - Ethics and compliance training?<br>
                    - A compliance officer?<br>
                    - A “whistleblowing” process?<br>
                    - A policy regarding international sanctions

                </td>
                <td colspan="2">
                    <br>
                    {{data.policy.p1}}<br>
                    {{data.policy.p2}}<br>
                    {{data.policy.p3}}<br>
                    {{data.policy.p4}}<br>
                    {{data.policy.p5}}<br>

                </td>

            </tr>

            <tr >
                <td colspan="2" style="">
                    Has the Public Client or its Directors been condemned for non-ethical practices or investigation is in progress :

                </td>
                <td colspan="2">
                    {{data.practice}}<br>
                    <span v-if="data.practice_detail!=null">{{data.practice_detail}}</span>
                </td>

            </tr>


            <tr>
                <td colspan="4" ><strong>Identified Red Flags</strong> 
                <p style="white-space:pre-wrap">{{data.flag}}</p> </td>
                
            </tr>
            <tr>
                <td colspan="4" ><strong>Proposed Mitigation Plan</strong> 
                <p style="white-space:pre-wrap">{{data.mitigation}}</p> </td>
                
            </tr>

            <tr>
                <td colspan="2">Approved By: &nbsp; {{data.pm_by}} </td>
                <td colspan="2" style="vertical-align: middle;">Date: &nbsp;{{data.pm_at}}</td>
            </tr>

            <tr v-if="data.status>3">
                 <td colspan="4" class="text-center" ><strong>COMPLIANCE OFFICER/MANAGER APPROVAL</strong></td>
            </tr>

            <tr v-if="data.comp_by!=null">
                <td colspan="2" >Name of the Compliance Officer/Manager</td>
                <td colspan="2" style="vertical-align: middle;">{{data.comp_by}}</td>
            </tr>

            <tr v-if="data.comp_by!=null">
                <td colspan="2" >Date</td>
                <td colspan="2" style="vertical-align: middle;">{{data.comp_at}}</td>
            </tr>

            <tr v-if="data.status>3">
                <td colspan="2" >Enhanced integrity review performed? </td>
                <td colspan="2" style="vertical-align: middle;">{{data.integrity}}<span class="ml-3" v-if="data.files.lexis_file!=''"><a :href="data.files.lexis_file" target="_blank" style="text-decoration:none"><v-icon>fas fa-paperclip</v-icon></a></span></td>
            </tr>

            <tr v-if="data.status>3">
                <td colspan="4" ><strong>Red flag identified from the enhanced integrity review and mitigating actions proposed:
                Amended action plan, if any</strong> <br><span style="white-space:pre-wrap">{{data.flag_action}}</span> </td>
            </tr>

            <tr v-if="data.status>3">
                <td colspan="2" >Decision</td>
                <td colspan="2" style="vertical-align: middle;">{{data.ims_decision.yn}}</td>
            </tr>


            <tr v-if="data.status>3">
                <td colspan="2" >Reason for this Decision </td>
                <td colspan="2" style="vertical-align: middle;">{{data.ims_reason}}</td>
            </tr>

            <tr v-if="data.status>3 && data.ims_condition!=null">
                <td colspan="2" >Condition </td>
                <td colspan="2" style="vertical-align: middle;">{{data.ims_condition}}</td>
            </tr>

            
            <tr v-if="data.remarks!=null">
                <td colspan="2"  >Additional information </td>
                <td colspan="2" style="vertical-align: middle;">{{data.ims_add}}</td>
            </tr>

            <!-- Group Compliance Manager -->

            <tr v-if="Object.keys(data.l1).length!=0">
                <td colspan="4" class="text-center"><strong>GROUP COMPLIANCE MANAGER APPROVAL</strong></td>
            </tr>

            <tr v-if="Object.keys(data.l1).length!=0">
                <td colspan="2">Name of the Group Compliance Manager</td>
                <td colspan="2" style="vertical-align: middle;">{{data.l1.l1_by}}</td>
            </tr>

            <tr v-if="Object.keys(data.l1).length!=0">
                <td colspan="2">Date</td>
                <td colspan="2" style="vertical-align: middle;">{{data.l1.l1_at}}</td>
            </tr>

            <tr v-if="Object.keys(data.l1).length!=0">
                <td colspan="2">Decision</td>
                <td colspan="2" style="vertical-align: middle;">{{data.l1.l1_decision.yn}}</td>
            </tr>

            <tr v-if="Object.keys(data.l1).length!=0">
                <td colspan="2">Reason for this Decision </td>
                <td colspan="2" style="vertical-align: middle;">{{data.l1.l1_reason}}</td>
            </tr>

            <tr v-if="Object.keys(data.l1).length!=0 && data.l1.l1_condition!=null">
                <td colspan="2">Condition </td>
                <td colspan="2" style="vertical-align: middle;">{{data.l1.l1_condition}}</td>
            </tr>

            <tr v-if="data.remarks!=null">
                <td colspan="2">Additional information </td>
                <td colspan="2" style="vertical-align: middle;">{{data.l1.l1_add}}</td>
            </tr>

            <!-- Ethics Committe -->

            <tr v-if="Object.keys(data.l2).length!=0">
                <td colspan="4" class="text-center"><strong>ETHICS COMMITTEE APPROVAL</strong></td>
            </tr>

            <tr v-if="Object.keys(data.l2).length!=0">
                <td colspan="2">Name of the Compliance Manager</td>
                <td colspan="2" style="vertical-align: middle;">{{data.l2.l2_by}}</td>
            </tr>

            <tr v-if="Object.keys(data.l2).length!=0">
                <td colspan="2">Date</td>
                <td colspan="2" style="vertical-align: middle;">{{data.l2.l2_at}}</td>
            </tr>

            <tr v-if="Object.keys(data.l2).length!=0">
                <td colspan="2">Decision</td>
                <td colspan="2" style="vertical-align: middle;">{{data.l2.l2_decision.yn}}</td>
            </tr>

            <tr v-if="Object.keys(data.l2).length!=0">
                <td colspan="2">Reason for this Decision </td>
                <td colspan="2" style="vertical-align: middle;">{{data.l2.l2_reason}}</td>
            </tr>

            <tr v-if="Object.keys(data.l2).length!=0 && data.l2.l2_condition!=null">
                <td colspan="2">Condition </td>
                <td colspan="2" style="vertical-align: middle;">{{data.l2.l2_condition}}</td>
            </tr>

            <tr v-if="data.remarks!=null">
                <td colspan="2">Additional information </td>
                <td colspan="2" style="vertical-align: middle;">{{data.l2.l2_add}}</td>
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
