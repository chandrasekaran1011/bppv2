<?php

namespace App\Http\Controllers\Ethics;

use App\Http\Controllers\Controller;
use App\Models\Ethics\Ethics;
use App\Models\Ethics\Partner;
use Illuminate\Http\Request;

class EditController extends Controller
{
    public function getEdit(Request $request){
        $data=array(
            array('field' => 'name', 'name' => 'Partner Name', 'type' => '0', 'table' => 'p'),
            array('field' => 'address', 'name' => 'Partner Address', 'type' => '0', 'table' => 'p'),
            array('field' => 'email', 'name' => 'Partner Email', 'type' => '0', 'table' => 'p'),
            array('field' => 'tp', 'name' => 'Third party', 'type' => '0', 'table' => 'p'),
            array('field' => 'license', 'name' => 'License', 'type' => '0', 'table' => 'p'),
            array('field' => 'cop_num', 'name' => 'Inciorporation Number', 'type' => '0', 'table' => 'p'),
            array('field' => 'cop_juri', 'name' => 'Incorporation Juristriction', 'type' => '0', 'table' => 'p'),
            array('field' => 'doi', 'name' => 'Date of Incorporation', 'type' => '0', 'table' => 'p'),
            array('field' => 'director', 'name' => 'Partner Directors', 'type' => '0', 'table' => 'p'),
            array('field' => 'subsidiary', 'name' => 'Partner Subsidiarys', 'type' => '0', 'table' => 'p'),
            array('field' => 'employee', 'name' => 'Partner Employees', 'type' => '0', 'table' => 'p'),
            array('field' => 'revenue', 'name' => 'Partner Revenues', 'type' => '2', 'table' => 'p'),
            array('field' => 'insolvency', 'name' => 'Insolvency', 'type' => '2', 'table' => 'p'),
            array('field' => 'org_type', 'name' => 'Partner Organisation Type', 'type' => '0', 'table' => 'p'),
            array('field' => 'policy', 'name' => 'Policy', 'type' => '1', 'table' => 'e'),
            array('field' => 'p1', 'name' => 'Policy Q1', 'type' => '1', 'table' => 'e'),
            array('field' => 'p2', 'name' => 'Policy Q2', 'type' => '1', 'table' => 'e'),
            array('field' => 'p3', 'name' => 'Policy Q3', 'type' => '1', 'table' => 'e'),
            array('field' => 'p4', 'name' => 'Policy Q4', 'type' => '1', 'table' => 'e'),
            array('field' => 'p5', 'name' => 'Policy Q5', 'type' => '1', 'table' => 'e'),
            array('field' => 'person', 'name' => 'Question 2', 'type' => '2', 'table' => 'e'),
            array('field' => 'person_detail', 'name' => 'Question 2 Detail', 'type' => '0', 'table' => 'e'),
            array('field' => 'benefit_detail', 'name' => 'Question 4', 'type' => '0', 'table' => 'e'),
            array('field' => 'q1', 'name' => 'Relation Q1', 'type' => '2', 'table' => 'e'),
            array('field' => 'q2', 'name' => 'Relation Q2', 'type' => '2', 'table' => 'e'),
            array('field' => 'q3', 'name' => 'Relation Q3', 'type' => '2', 'table' => 'e'),
            array('field' => 'q4', 'name' => 'Relation Q4', 'type' => '2', 'table' => 'e'),
            array('field' => 'q5', 'name' => 'Relation Q5', 'type' => '2', 'table' => 'e'),
            array('field' => 'q_detail', 'name' => 'Relation Detail', 'type' => '0', 'table' => 'e'),
            array('field' => 'r_detail', 'name' => 'Question 5', 'type' => '0', 'table' => 'e'),
            array('field' => 's_detail', 'name' => 'Question 6', 'type' => '0', 'table' => 'e'),
            array('field' => 't', 'name' => 'Certificate', 'type' => '2', 'table' => 'e'),
            array('field' => 'p_name', 'name' => 'Questionnaire Submitted By', 'type' => '0', 'table' => 'e'),
            array('field' => 'p_des', 'name' => 'Questionnaire Submitted Designation', 'type' => '0', 'table' => 'e'),
            array('field' => 'phase', 'name' => 'Phase', 'type' => '0', 'table' => 'e'),
            array('field' => 'scope', 'name' => 'Scope', 'type' => '0', 'table' => 'e'),
            array('field' => 'contract', 'name' => 'Project/Contract', 'type' => '0', 'table' => 'e'),
            array('field' => 'cdo', 'name' => 'CDO', 'type' => '2', 'table' => 'e'),
            array('field' => 'cdo_date', 'name' => 'CDO DATE', 'type' => '0', 'table' => 'e'),
            array('field' => 'mutual', 'name' => 'Mutual', 'type' => '2', 'table' => 'e'),
            array('field' => 'recomm', 'name' => 'Recommendation', 'type' => '2', 'table' => 'e'),
            array('field' => 'search', 'name' => 'Internet Search', 'type' => '1', 'table' => 'e'),
            array('field' => 'satis', 'name' => 'Satisfactory', 'type' => '1', 'table' => 'e'),
            array('field' => 'practice', 'name' => 'Practices', 'type' => '0', 'table' => 'e'),
            array('field' => 'practice_detail', 'name' => 'Practices detail', 'type' => '0', 'table' => 'e'),
            array('field' => 'need', 'name' => 'Need Validaion', 'type' => '1', 'table' => 'e'),
            array('field' => 'flag', 'name' => 'Red Flags', 'type' => '0', 'table' => 'e'),
            array('field' => 'mitigation', 'name' => 'Mitigation Action', 'type' => '0', 'table' => 'e'),
            array('field' => 'ims_reason', 'name' => 'Compliance Reason', 'type' => '0', 'table' => 'e'),
            array('field' => 'ims_condition', 'name' => 'Compliance Condition', 'type' => '0', 'table' => 'e'),
            array('field' => 'ims_add', 'name' => 'Compliance Remarks', 'type' => '0', 'table' => 'e'),
            array('field' => 'integrity', 'name' => 'Integrity', 'type' => '2', 'table' => 'e'),
            array('field' => 'flag_action', 'name' => 'Flag Action', 'type' => '0', 'table' => 'e'),
            array('field' => 'l1_reason', 'name' => 'Group Head Reason', 'type' => '0', 'table' => 'e'),
            array('field' => 'l1_condition', 'name' => 'Group Head Condition', 'type' => '0', 'table' => 'e'),
            array('field' => 'l1_add', 'name' => 'Group Head Remarks', 'type' => '0', 'table' => 'e'),
            array('field' => 'l2_reason', 'name' => 'Ethics Committee Reason', 'type' => '0', 'table' => 'e'),
            array('field' => 'l2_condition', 'name' => 'Ethics Committee Condition', 'type' => '0', 'table' => 'e'),
            array('field' => 'l2_add', 'name' => 'Ethics Committee Remarks', 'type' => '0', 'table' => 'e'),
            array('field' => 'finance_remarks', 'name' => 'Finance Remarks', 'type' => '0', 'table' => 'e'),
            array('field' => 'renew_phase', 'name' => 'Renewal Phase', 'type' => '0', 'table' => 'e'),
            array('field' => 'renew_scope', 'name' => 'Renewal Scope', 'type' => '0', 'table' => 'e'),
            array('field' => 'renew_contract', 'name' => 'Renewal Contract', 'type' => '0', 'table' => 'e'),
            array('field' => 'renew_cdo', 'name' => 'Renewal Cdo', 'type' => '1', 'table' => 'e'),
            array('field' => 'renew_cdo_date', 'name' => 'Renewal Cdo Date', 'type' => '0', 'table' => 'e'),
            array('field' => 'renew_mutual', 'name' => 'Renewal Mutual', 'type' => '1', 'table' => 'e'),
            array('field' => 'renew_recomm', 'name' => 'Renewal Recomm', 'type' => '1', 'table' => 'e'),
            array('field' => 'renew_search', 'name' => 'Renewal Search', 'type' => '1', 'table' => 'e'),
            array('field' => 'renew_flag', 'name' => 'Renewal Flag', 'type' => '0', 'table' => 'e'),
            array('field' => 'renew_mitigation', 'name' => 'Renewal Mitigation', 'type' => '0', 'table' => 'e'),
            array('field' => 'renew_ims_reason', 'name' => 'Renewal Ims Reason', 'type' => '0', 'table' => 'e'),
            array('field' => 'renew_ims_condition', 'name' => 'Renewal Ims Condition', 'type' => '0', 'table' => 'e'),
            array('field' => 'renew_ims_add', 'name' => 'Renewal Ims Remarks', 'type' => '0', 'table' => 'e'),
            array('field' => 'renew_integrity', 'name' => 'Renewal Integrity', 'type' => '2', 'table' => 'e'),
            array('field' => 'renew_breach', 'name' => 'Renewal Breach', 'type' => '2', 'table' => 'e'),
        );

        $field1=["id","name", 
        "address", 
        "email", 
        "tp", 
        "license", 
        "cop_num", 
        "cop_juri", 
        "doi", 
        "director", 
        "subsidiary", 
        "employee", 
        "revenue", 
        "insolvency", 
        "org_type"];

        $field2=["policy", "p1", "p2", "p3", "p4", "p5", "person", "person_detail", "benefit_detail", "q1", "q2", "q3", "q4", "q5", "q_detail", "r_detail", "s_detail", "t", "p_name", "p_des", "phase", "scope", "contract", "cdo", "cdo_date", "mutual", "recomm", "search", "satis", "practice", "practice_detail", "need", "flag", "mitigation", "ims_reason", "ims_condition", "ims_add", "integrity", "flag_action", "l1_reason", "l1_condition", "l1_add", "l2_reason", "l2_condition", "l2_add", "finance_remarks", "renew_phase", "renew_scope", "renew_contract", "renew_cdo", "renew_cdo_date", "renew_mutual", "renew_recomm", "renew_search", "renew_flag", "renew_mitigation", "renew_ims_reason", "renew_ims_condition", "renew_ims_add", "renew_integrity", "renew_breach"];
        
        $e = Partner::where('uuid', $request->id)->select($field1)->first();
        $values=[];
        if($e){
            $p=Ethics::where('partner_id',$e->id)->select($field2)->first()->toArray();
            //$values=collect($e)->merge($e->ethics->select($field2)->first());
            $values=array_merge($e->toArray(), $p);
            
            return response()->json(['values'=>$values,"fields"=>$data], 200);
        }else{
            return response()->json(['Message Something Went Wrong'], 500);
        }
    }


    public function updatePartner(Request $request){
        
        $e = Partner::where('uuid', $request->id)->with('ethics')->select('id')->first();
        $field=$request->field;
        if($e){
            if($request->table=='p'){
                $e->$field=$request->value;
                $check=$e->save();
            }else{
                $e->ethics->$field=$request->value;
                $check=$e->ethics->save();
            }
            if($check){
                return response()->json(['message'=>'Partner Updated'], 200);
            }
        }else{
            return response()->json(['message'=>'Error while Updating'], 500);
        }
    
    }
}
