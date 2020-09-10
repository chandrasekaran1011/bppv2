<template>
<div>
    <div class="title grad text-left pa-3 ">Ethics, compliance and political exposure</div>
    <table class="tble table-bordered mt-2" v-if="data.type.value!=8" style="width:100%">
        <tbody>

            <tr>
                <td colspan="2" style="background-color:#dee2e6;max-width:50%;min-width:50%;width:70%">Does your organization have policies and a programme to ensure ethical business practices and prevent bribery and corruption ?</td>
                <td colspan="2" style="vertical-align: middle;">{{data.policy.yn}}<span class="ml-3" v-if="data.files.policy_file!==''"><a :href="data.files.policy_file" target="_blank" style="text-decoration:none"><v-icon>fas fa-paperclip</v-icon></a></span></td>

            </tr>

            <tr>
                <td colspan="2" style="background-color:#dee2e6;padding-left:2rem">
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

            <tr>
                <td colspan="2" style="background-color:#dee2e6;">Does any government entity, Public Official or Relevant Person own an interest in, or exert control over your organization?</td>
                <td colspan="2" style="vertical-align: middle;">{{data.person.yn}} <br> <span  v-if="data.person.value!='0'"></span></td>

            </tr>

            <tr>
                <td colspan="2" style="background-color:#dee2e6;">

                    Is any of your organization Principals (as defined above) a <br>
                    <div class="pl-3">
                        - Public Official, whose mission could have repercussions on SYSTRA Group business?<br>
                        - Systra Group employee?<br>
                        - Relevant Person?<br>
                        - Family member or personal or professional associate of one of the above?<br>
                        - Person subject to any international sanctions?<br>

                    </div>
                </td>

                <td colspan="2">
                    {{data.q.q1}}<br>
                    {{data.q.q2}}<br>
                    {{data.q.q3}}<br>
                    {{data.q.q4}}<br>
                    {{data.q.q5}}<br>
                    Additional Infromation (if any):{{data.q.q_detail}}
                </td>

            </tr>

            <tr>
                <td colspan="2" style="background-color:#dee2e6;">Does any Public Official or Relevant Person stand to personal benefit in any way as a result of the proposed agreement with Systra ?</td>
                <td colspan="2" style="vertical-align: middle;">{{data.benefit_detail}}</td>
            </tr>

            <tr>
                <td colspan="2" style="background-color:#dee2e6;">Has your organization or any of your subsidiaries or any of your organization Principal or subsidiaries’ Principal been, during the five past years, the subject of investigations, proceedings, convictions, debarments and/or professional suspensions related to (or have otherwise been involved in) corruption, anticompetitive practices, fraud, money-laundering, violation of international sanctions or related offences?</td>
                <td colspan="2" style="vertical-align: middle;">{{data.r_detail}} </td>
            </tr>

            <tr>
                <td colspan="2" style="background-color:#dee2e6;">Has your organization or any of your subsidiaries or any of your organization Principal or subsidiaries’ Principal been listed on a national or international sanction list, including U.S. OFAC Specially Designated Nationals (SDN) and Blocked Persons List?</td>
                <td colspan="2" style="vertical-align: middle;">{{data.s_detail}} </td>

            </tr>

            <tr>
                <td colspan="2" style="background-color:#dee2e6;">Does your organization have external certifications regarding ethics? (e.g. ISO 37001)</td>
                <td colspan="2" style="vertical-align: middle;">{{data.cert.yn}}<span class="ml-3" v-if="data.files.cert_file!=''"><a :href="data.files.cert_file" target="_blank" style="text-decoration:none"><v-icon>fas fa-paperclip</v-icon></a></span></td>

            </tr>

            <tr>
                <td colspan="2" style="background-color:#dee2e6;">Last 3 years Annual Statement</td>
                <td colspan="2" style="vertical-align: middle;"> <span class="ml-3" v-if="data.files.statement_file!=''"><a :href="data.files.statement_file" target="_blank" style="text-decoration:none"><v-icon>fas fa-paperclip</v-icon></a></span></td>
            </tr>

            <tr>
                <td colspan="2" style=""> Submitted by: &nbsp;{{data.p_name}} ({{data.p_des}})</td>
                <td colspan="2" style="vertical-align: middle;">Date : {{data.submitted_on}}  </td>
            </tr>
           

        </tbody>
    </table>

    <table class="tble table-bordered mt-2" v-if="data.type.value==8" style="width:100%">
        <tbody>

 
            <tr>
                <td colspan="2" style="background-color:#dee2e6;">Are you a Public Official? </td>
                <td colspan="2" style="vertical-align: middle;min-width:300px;">{{data.person.yn}} <br> <span  v-if="data.person.value!='0'">{{data.person.detail}}</span></td>

            </tr>

            <tr>
                <td colspan="2" style="background-color:#dee2e6;">

                    Do you have any personal or professional relationship with:<br>
                    <div class="pl-3">
                        - A Public Official?<br>
                        - An employee of SYSTRA Group? <br>
                        - A Relevant Person? <br>
                        - A person subject to any international sanction?<br>

                    </div>
                </td>

                <td colspan="2" style="min-width:300px;">
                    {{data.q.q1}}<br>
                    {{data.q.q2}}<br>
                    {{data.q.q3}}<br>

                    {{data.q.q5}}<br>
                    Additional Infromation (if any):{{data.q.q_detail}}
                </td>

            </tr>

            <tr>
                <td colspan="2" style="background-color:#dee2e6;">Does any Public Official or Relevant Person stand to personal benefit in any way as a result of the proposed agreement with Systra ?</td>
                <td colspan="2" style="vertical-align: middle;min-width:300px;">{{data.benefit_detail}}</td>
            </tr>

            <tr>
                <td colspan="2" style="background-color:#dee2e6;">Have you been, during the five past years, the subject of investigations, proceedings, convictions, debarments and/or professional suspensions related to (or have otherwise been involved in) corruption, anticompetitive practices, fraud, money-laundering, violation of international sanctions or related offences?</td>
                <td colspan="2" style="vertical-align: middle;">{{data.r_detail}} </td>
            </tr>

            <tr>
                <td colspan="2" style="background-color:#dee2e6;">Have you been listed on a national or international sanction list, including U.S. OFAC Specially Designated Nationals (SDN) and Blocked Persons List?</td>
                <td colspan="2" style="vertical-align: middle;">{{data.s_detail}} </td>

            </tr>

            <tr>
                <td colspan="2" style="background-color:#dee2e6;"> Tax Return Statement</td>
                <td colspan="2" style="vertical-align: middle;"><span class="ml-3" v-if="data.files.statement_file!==''"><a :href="data.files.statement_file" target="_blank" style="text-decoration:none"><v-icon>fas fa-paperclip</v-icon></a></span> </td>
            </tr>

            <tr>
                <td colspan="2" style=""> Submitted by: &nbsp;{{data.p_name}}</td>
                <td colspan="2" style="vertical-align: middle;">Date : {{data.submitted_on}}  </td>
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
