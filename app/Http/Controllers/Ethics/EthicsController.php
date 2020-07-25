<?php

namespace App\Http\Controllers\Ethics;


use App\Http\Controllers\Controller;
use App\Http\Requests\Ethics\IndividualFormRequest;
use Illuminate\Http\Request;

//Utilities
use Session;
use Carbon\Carbon;
use Notification;
use Illuminate\Notifications\Notifiable;
use App\Notifications\PartnerQuestionnaireNotification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Log;

//Models
use App\Models\Ethics\PartnerType;
use App\Models\Admin\Project;
use App\Models\Admin\Country;
use App\Models\Admin\User;
use App\Models\Ethics\Mitigation;
use App\Models\Ethics\RedFlag;
use App\Models\Ethics\Partner;
use Auth;

use App\Models\Ethics\Ethics;

//Requests

use App\Http\Requests\Ethics\PartnerForm;

class EthicsController extends Controller
{
    public function index(Request $r)
    {

        $partner = PartnerType::all();
        $p = [];
        foreach ($partner as $type) {
            $p[] = ['id' => $type->id, 'name' => $type->name];
        }


        return view('ethics.index')->with('partner', json_encode($p, true));
    }

    public function getFormData(Request $r)
    {
        if(isset($r->id)){
            $partner = PartnerType::where('id', $r->id)->select('name')->first();
        }else{
            $partner =null;
        }
        

        $entity = Project::getDataArray();
        $country = Country::getDataArray();
        $flags = RedFlag::allFlagsArray();
        $mitigations = Mitigation::allMitigationsArray();

        $imsUsers = User::permission('Compliance Approver')->select(['id', 'name'])->get();

        $userData = [];
        foreach ($imsUsers as $u) {
            $userData[] = [
                'unique' => $u->id,
                'name' => $u->name
            ];
        }

        return response()->json(['flags' => $flags, 'mitigations' => $mitigations, 'partner' => $partner, 'entity' => $entity, 'country' => $country, 'approver' => $userData], 200);
    }

    public function storePublicForm(Request $request)
    {

        $p = new partner();

        $p->name = $request->name;
        $p->project_id = $request->project_id;
        $p->type_id = 1;
        $p->address = $request->address;
        $p->country_id = $request->country;
        $p->cpi = $request->cpi;
        $p->cop_num = $request->cop_num;
        $p->cop_juri = $request->cop_juri;
        $p->doi = $request->doi;
        $p->stock = $request->stock;
        $p->stock_name = $request->stock_name;
        $p->stock_detail = $request->stock_detail;
        $p->director = $request->director;

        $p->subsidiary = $request->subsidiary;
        $p->employee = $request->employee;


        $p->status = 3;
        $p->cuser = Auth::id();

        $p->save();


        $e = new ethics();

        $e->partner_id = $p->id;

        $e->policy = $request->policy;
        $e->p1 = $request->p1;
        $e->p2 = $request->p2;
        $e->p3 = $request->p3;
        $e->p4 = $request->p4;
        $e->p5 = $request->p5;
        $e->pcountry = $request->pcountry;
        $e->pcpi = $request->pcpi;
        $e->phase = $request->phase;

        $file1 = $request->hasFile('policy_file');
        if ($file1) {
            $extension = $request->file('policy_file')->extension();
            if ($extension == 'pdf') {
                $policy_file = $p->uuid . '/policy/' . md5(date('Y-m-d H:i')) . '.' . $extension;
                Storage::disk('myDisk')->put($policy_file, File::get($request->file('policy_file')));
                $e->policy_file = $policy_file;
            }
        }

        $e->scope = $request->scope;
        $e->contract = $request->contract;

        $e->cdo = $request->cdo;
        if ($request->dcdo) {
            $e->cdo_date = $request->dcdo;
        }

        $e->mutual = $request->mutual;
        $e->recomm = $request->recomm;

        $e->search = $request->search;

        $file = $request->hasFile('screenshot_file');
        if ($file) {
            $extension = $request->file('screenshot_file')->extension();
            if ($extension == 'pdf') {
                $search_file = $p->uuid . '/search/' . md5(date('Y-m-d H:i')) . '.' . $extension;
                Storage::disk('myDisk')->put($search_file, File::get($request->file('screenshot_file')));
                $e->screenshot_file = $search_file;
            }
        }


        $e->practice = $request->practice;
        $e->flag = $request->flag;
        $e->mitigation = $request->mitigations;

        $e->pm_by = Auth::id();
        $e->pm_at = Carbon::now();

        $e->ims_assign = $request->ims_assign;

        $check = $e->save();

        if ($check) {

            return response()->json(['message' => 'Business Partner Created'], 200);
        } else {
            Partner::where('id', $p->id)->delete();
            return response()->json(['message' => 'Error Creating Business partner'], 500);
        }
    }

    public function  storeOtherForm(Request $request)
    {
        $p = new partner();

        $p->name = $request->name;
        $p->project_id = $request->project;
        $p->type_id = $request->type_id;
        $p->email = $request->email;
        $p->country_id = $request->country;
        $p->cpi = $request->cpi;
        $p->status = 1;
        $p->cuser = Auth::id();

        $check = $p->save();

        if ($check) {

            Notification::route('mail', $request->email)->notify(new PartnerQuestionnaireNotification($p));

            //event(new PartnerRegistrationInitiated($p));

            return response()->json(['message' => 'Business Partner Created'], 200);
        } else {

            return response()->json(['message' => 'Error Creating Business partner'], 500);
        }
    }

    public function PartnerQuestion(Request $request, $id)
    {
        if (!$request->hasValidSignature()) {
            return "Time Expired";
        } else {
            $e = Partner::where('uuid', $id)->where('status', 1)->first();
            if ($e) {
                if ($e->type_id != 8) {
                    return view('ethics.partnerForm')->with('ethics', $e);
                } else {
                    return view('ethics.individualForm')->with('ethics', $e);
                }
            } else {
                return "Form already Submitted";
            }
        }
    }

    public function partnerstore($id, PartnerForm  $request)
    {
        //PartnerForm    
        //dd($request);

        $p = Partner::where('uuid', $id)->where('status', 1)->first();
        if ($p) {
            $p->name = $request->name;
            $p->address = $request->address;
            $p->cop_num = $request->cop_num;
            $p->cop_juri = $request->cop_juri;
            $p->doi = $request->doi;
            $p->stock = $request->stock;
            $p->stock_name = $request->stock_name;
            $p->stock_detail = $request->stock_detail;
            $p->director = $request->director;
            $p->tp = $request->tp;

            $p->status = 2;

            $p->question_submitted_on=Carbon::now();

            $p->subsidiary = $request->subsidiary;
            $p->employee = $request->employee;
            $p->revenue = $request->revenue;
            $p->insolvency = $request->insolvency;

            $check = $p->save();

            $e = new ethics();

            $e->partner_id = $p->id;

            $e->policy = $request->policy;

            $e->p1 = $request->p1;
            $e->p2 = $request->p2;
            $e->p3 = $request->p3;
            $e->p4 = $request->p4;
            $e->p5 = $request->p5;

            $e->person = $request->person;

            $e->person_detail = $request->person_detail;

            $e->q1 = $request->q1;
            $e->q2 = $request->q2;
            $e->q3 = $request->q3;
            $e->q4 = $request->q4;
            $e->q5 = $request->q5;

            $e->q_detail = $request->q_detail;
            $e->r_detail = $request->r_detail;
            $e->s_detail = $request->s_detail;
            $e->benefit_detail = $request->benefit_detail;

            $e->t = $request->t;

            $e->p_name = $request->p_name;
            $e->p_des = $request->p_des;

            $file1 = $request->hasFile('policy_file');
            if ($file1) {
                $extension = $request->file('policy_file')->extension();
                $policy_file = $p->uuid . '/policy/' . md5(date('Y-m-d H:i')) . '.' . $extension;
                Storage::disk('myDisk')->put($policy_file, File::get($request->file('policy_file')));
                $e->policy_file = $policy_file;
            }

            $file2 = $request->hasFile('certi_file');
            if ($file2) {
                $extension = $request->file('certi_file')->extension();
                $certi_file = $p->uuid . '/ethicsCert/' . md5(date('Y-m-d H:i')) . '.' . $extension;
                Storage::disk('myDisk')->put($certi_file, File::get($request->file('certi_file')));
                $e->cert_file = $certi_file;
            }


            $file3 = $request->hasFile('statement_file');
            if ($file3) {
                $extension = $request->file('statement_file')->extension();
                $statement_file = $p->uuid . '/statement/' . md5(date('Y-m-d H:i')) . '.' . $extension;
                Storage::disk('myDisk')->put($statement_file, File::get($request->file('statement_file')));
                $e->statement_file = $statement_file;
            }



            $check = $e->save();

            if ($check) {
                //event(new PartnerQuestionnaireSubmitted($p));
                return "Form  Submitted";
            } else {
                return "Something went wrong";
            }
        } else {
            return "Error Occured";
        }
    }
     //Individual Partner Form
    public function individualPartnerstore($id, IndividualFormRequest $request)
    {

        $p = Partner::where('uuid', $id)->where('status', 1)->first();
        if ($p) {
            $p->name = $request->name;
            $p->address = $request->address;
            $p->cop_num = $request->cop_num;
            $p->cop_juri = $request->cop_juri;
            $p->doi = $request->doi;

            $p->status = 2;
            $p->question_submitted_on=Carbon::now();
            $p->revenue = $request->revenue;
            $p->tp = $request->tp;
            $p->license = $request->license;

            $check = $p->save();

            if ($check) {
                $e = new ethics();

                $e->partner_id = $p->id;
                

                $e->person = $request->person;
                $e->person_detail = $request->person_detail;

                $e->q1 = $request->q1;
                $e->q2 = $request->q2;
                $e->q3 = $request->q3;
                $e->q4 = $request->q4;
                $e->q5 = $request->q5;

                $e->q_detail = $request->q_detail;
                $e->r_detail = $request->r_detail;
                $e->s_detail = $request->s_detail;
                $e->benefit_detail = $request->benefit_detail;

                $e->p_name = $request->p_name;
                $e->p_des = $request->p_des;


                $file3 = $request->hasFile('statement_file');
                if ($file3) {
                    $extension = $request->file('statement_file')->extension();
                    $statement_file = $p->uuid . '/statement/' . md5(date('Y-m-d H:i')) . '.' . $extension;
                    Storage::disk('myDisk')->put($statement_file, File::get($request->file('statement_file')));
                    $e->statement_file = $statement_file;
                }

                $check = $e->save();

                if ($check) {
                    //event(new PartnerQuestionnaireSubmitted($p));
                    return "Form  Submitted";
                } else {
                    return "Something went wrong";
                }
            } else {
                return "Error Occured.Contact Systra";
            }
        } else {
            return "Error Occured";
        }
    }

    public function view(){
        $user=Auth::user();

        if($user->isAdmin() || $user->can('View All Records')){
            $partner=Partner::all();
        }
        else if($user->can('View Entity Records')){
            $partner=Partner::whereIn('project_id',$user->getProjectsIDs())->orWhere('ims_assign',$user->id)->get();
        }else if($user->can('View Own Records')){
            $partner=Partner::where('cuser',$user->id)->orWhere('ims_assign',$user->id)->get(); 
        }else{
            return response()->json(['message'=>'Error in Permissions'], 500);   
        }

        if($partner->count()>0){
            $data=[];
            $x=1;
            foreach($partner as $p){
                $data[]=[
                    'x'=>$x,
                    'id'=>$p->uuid,
                    'name'=>$p->name,
                    'status'=>$p->getStatus(),
                    'type'=>$p->type->name,
                ];
                $x++;
            }
            return response()->json($data, 200);

        }else{
            return response()->json(['message'=>'No Data Found'], 500);
        }



    }

    public function detail(Request $request)
    {
        $user=Auth::user();
        $e = Partner::where('uuid', $request->id)->with('ethics')->first();

        $doi = $e->doi == null ? '' : $e->doi->toFormattedDateString();
        $data = [
            'name' => $e->name,
            'type' => ['value' => $e->type_id, 'name' => $e->type->name],
            'address' => $e->address,
            'status' => $e->status,
            'doi' => $doi,
            'cop_num' => $e->cop_num,
            'cop_juri' => $e->cop_juri,
            'license' => $e->license,
            'stock' => [
                'value' => $e->stock,
                'yn' => $e->yn($e->stock),
                'name' => $e->stock_name,
                'detail' => $e->stock_detail
            ],
            'director' => $e->director,
            'subsidiary' => $e->subsidiary,
            'employee' => $e->employee,
            'revenue' => $e->yn($e->revenue),
            'insolvency' => $e->yn($e->insolvency),
            'tp'=>$e->tp,

            'policy'=>[
                'value'=>$e->ethics->policy,
                'yn'=>$e->yn($e->ethics->policy),
                'file'=>$e->ethics->policy_file,
                'p1'=>$e->yn($e->ethics->p1),
                'p2'=>$e->yn($e->ethics->p2),
                'p3'=>$e->yn($e->ethics->p3),
                'p4'=>$e->yn($e->ethics->p4),
                'p5'=>$e->yn($e->ethics->p5),
            ],
            'person'=>[
                'value'=>$e->ethics->person,
                'yn'=>$e->yn($e->ethics->person),
                'detail'=>$e->ethics->person_detail,
            ],
            'q'=>[
                'q_detail'=>$e->ethics->q_detail,
                'q1'=>$e->yn($e->ethics->q1),
                'q2'=>$e->yn($e->ethics->q2),
                'q3'=>$e->yn($e->ethics->q1),
                'q4'=>$e->yn($e->ethics->q1),
                'q5'=>$e->yn($e->ethics->q1),
            ],
            'r_detail'=>$e->ethics->r_detail,
            'benefit_detail'=>$e->ethics->benefit_detail,
            's_detail'=>$e->ethics->s_detail,
            'cert'=>[
                'yn'=>$e->yn($e->ethics->t),
                'file'=>$e->ethics->certi_file
            ],
            'finance'=>[
                'file'=>$e->ethics->statement_file
            ],
            'p_name'=>$e->ethics->p_name,
            'p_des'=>$e->ethics->p_des,
            'submitted_on'=>$e->question_submitted_on,

            'pmApprover'=> $user->can('pmApprove',$e),
    
        ];

        if ($e) {
            return response()->json($data, 200);
        } else {
            abort(404);
        }
    }


}
