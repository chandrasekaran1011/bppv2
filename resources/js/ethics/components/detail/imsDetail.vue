<template>
<div>
    <div>
        <div class="title grad text-left pa-3 ">Compliance Manager Approval</div>

        <table class="tble table-bordered mt-2" style="width:100%">
            <tbody>

                <tr>
                    <td colspan="2" style="min-width:30%;width:40%">Enhanced integrity review performed ?</td>
                    <td colspan="2" style="vertical-align: middle;">{{data.integrity}}</td>

                </tr>

                <tr>
                    <td colspan="2">Red flag identified from the enhanced integrity review and mitigating actions proposed:<br>Amended action plan, if any</td>
                    <td colspan="2" class="spacing" style="vertical-align: middle;">{{data.flag_action}}</td>

                </tr>

                <tr>
                    <td colspan="2">Decision</td>
                    <td colspan="2" style="vertical-align: middle;">{{data.ims_decision.yn}}</td>

                </tr>

                <tr v-if="data.ims_decision.value==2">
                    <td colspan="2">Conditions</td>
                    <td colspan="2" class="spacing" style="vertical-align: middle;">{{data.ims_condition}}</td>

                </tr>

                <tr>
                    <td colspan="2" class="spacing">Reason for Decision</td>
                    <td colspan="2" style="vertical-align: middle;" class="spacing">{{data.ims_reason}}</td>
                </tr>

                <tr>
                    <td colspan="2" class="spacing">Addition Info</td>
                    <td colspan="2" style="vertical-align: middle;" class="spacing">{{data.ims_add}}</td>
                </tr>

                <tr>
                    <td colspan="2">Approved By: &nbsp; {{data.comp_by}} </td>
                    <td colspan="2" style="vertical-align: middle;">Date: &nbsp;{{data.comp_at}}</td>
                </tr>

            </tbody>
        </table>
    </div>

    <div v-if="Object.keys(data.l1).length!=0">
        <div class="title grad text-left pa-3 ">Group Compliance Manager</div>

        <table class="tble table-bordered mt-2" style="width:100%">
            <tbody>


                <tr>
                    <td colspan="2">Decision</td>
                    <td colspan="2" style="vertical-align: middle;">{{data.l1.l1_decision.yn}}</td>

                </tr>

                <tr v-if="data.l1.l1_decision.value==2">
                    <td colspan="2">Conditions</td>
                    <td colspan="2" style="vertical-align: middle;">{{data.l1.l1_condition}}</td>

                </tr>

                <tr>
                    <td colspan="2" class="spacing">Reason for Decision</td>
                    <td colspan="2" style="vertical-align: middle;" class="spacing">{{data.l1.l1_reason}}</td>
                </tr>

                <tr>
                    <td colspan="2" class="spacing">Addition Info</td>
                    <td colspan="2" style="vertical-align: middle;" class="spacing">{{data.l1.l1_add}}</td>
                </tr>

                <tr>
                    <td colspan="2">Approved By: &nbsp; {{data.l1.l1_by}} </td>
                    <td colspan="2" style="vertical-align: middle;">Date: &nbsp;{{data.l1.l1_at}}</td>
                </tr>

            </tbody>
        </table>
    </div>

    <div v-if="Object.keys(data.l2).length!=0">
        <div class="title grad text-left pa-3 ">Compliance Manager Approval</div>

        <table class="tble table-bordered mt-2" style="width:100%">
            <tbody>

                <tr>
                    <td colspan="2" style="min-width:30%;width:40%">Enhanced integrity review performed ?</td>
                    <td colspan="2" style="vertical-align: middle;">{{data.integrity}}</td>

                </tr>

                <tr>
                    <td colspan="2">Red flag identified from the enhanced integrity review and mitigating actions proposed:<br>Amended action plan, if any</td>
                    <td colspan="2" class="spacing" style="vertical-align: middle;">{{data.flag_action}}</td>

                </tr>

                <tr>
                    <td colspan="2">Decision</td>
                    <td colspan="2" style="vertical-align: middle;">{{data.ims_decision.yn}}</td>

                </tr>

                <tr v-if="data.decision.value==2">
                    <td colspan="2">Conditions</td>
                    <td colspan="2" style="vertical-align: middle;">{{data.ims_condition}}</td>

                </tr>

                <tr>
                    <td colspan="2" class="spacing">Reason for Decision</td>
                    <td colspan="2" style="vertical-align: middle;" class="spacing">{{data.ims_reason}}</td>
                </tr>

                <tr>
                    <td colspan="2" class="spacing">Addition Info</td>
                    <td colspan="2" style="vertical-align: middle;" class="spacing">{{data.ims_add}}</td>
                </tr>

                <tr>
                    <td colspan="2">Approved By: &nbsp; {{data.comp_by}} </td>
                    <td colspan="2" style="vertical-align: middle;">Date: &nbsp;{{data.comp_at}}</td>
                </tr>

            </tbody>
        </table>
    </div>

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
