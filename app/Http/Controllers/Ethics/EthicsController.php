<?php

namespace App\Http\Controllers\Ethics;


use App\Http\Controllers\Controller;
use App\Http\Requests\Ethics\IndividualFormRequest;
use Illuminate\Http\Request;

//Utilities
use Session;
use Cache;
use Carbon\Carbon;
use Notification;
use Illuminate\Notifications\Notifiable;
use App\Notifications\PartnerQuestionnaireNotification;
use App\Notifications\ApprovalNotification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Log;


// Events
use App\Events\Ethics\PartnerRegistrationInitiated;
use App\Events\Ethics\PublicPartnerRegistrationInitiated;
use App\Events\Ethics\PartnerQuestionnaireSubmitted;
use App\Events\Ethics\PmApproved;
use App\Events\Ethics\ComplianceDecision;
use App\Events\Ethics\PartnerRegistered;

//Models
use App\Models\Ethics\PartnerType;
use App\Models\Admin\Project;
use App\Models\Admin\Country;
use App\Models\Admin\User;
use App\Models\Ethics\Mitigation;
use App\Models\Ethics\RedFlag;
use App\Models\Ethics\Partner;
use Auth;
use App\Models\Ethics\Renew;

use App\Models\Ethics\Ethics;

//Requests

use App\Http\Requests\Ethics\PartnerForm;
use App\Jobs\Ethics\createPDF;

class EthicsController extends Controller
{
    public function index(Request $r)
    {

        $p = [];
        $p = Cache::remember('typeAll', 864000, function () {
            $partners = PartnerType::all();
            $list = [];
            foreach ($partners as $part) {
                $list[] = ['id' => $part->id, 'name' => $part->name];
            }
            return $list;
        });

        return view('ethics.index')->with('partner', json_encode($p, true));
    }

    public function getFormData(Request $r)
    {
        if (isset($r->id)) {
            $partner = PartnerType::where('id', $r->id)->select('name', 'id')->first();
        } else {
            $partner = null;
        }


        $entity = Project::getDataArray();
        $country = Country::getDataArray();
        $flags = RedFlag::allFlagsArray();
        $mitigations = Mitigation::allMitigationsArray();

        $imsUsers = User::permission('Compliance Approver')->select(['id', 'name'])->get();
        $fin_Users = User::permission('Finance Approver')->select(['id', 'name'])->get();

        $type = Cache::remember('typeIndividualAll', 864000, function () {
            $partners = PartnerType::where('id', '!=', 8)->get();
            $list = [];
            foreach ($partners as $part) {
                $list[] = ['id' => $part->id, 'name' => $part->name];
            }
            return $list;
        });



        $userData = [];
        foreach ($imsUsers as $u) {
            $userData[] = [
                'unique' => $u->id,
                'name' => $u->name
            ];
        }

        $financeUsers = [];
        foreach ($fin_Users as $u) {
            $financeUsers[] = [
                'unique' => $u->id,
                'name' => $u->name
            ];
        }

        return response()->json(['typeList' => $type, 'flags' => $flags, 'mitigations' => $mitigations, 'partner' => $partner, 'entity' => $entity, 'country' => $country, 'approver' => $userData, 'finance_approvers' => $financeUsers], 200);
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

        $p->spot_code=$request->spot;
        $p->bview = $request->bview;

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

        // $e->scope = $request->scope;
        $e->contract = $request->contract;

        $e->cdo = $request->cdo;
        if ($request->dcdo) {
            $e->cdo_date = $request->dcdo;
        }

        // $e->mutual = $request->mutual;
        // $e->recomm = $request->recomm;

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
        $e->practice_detail = $request->practice_detail;
        $e->flag = $request->flag;
        $e->mitigation = $request->mitigations;

        $e->pm_by = Auth::id();
        $e->pm_at = Carbon::now();

        $e->ims_assign = $request->ims_assign;

        $check = $e->save();

        if ($check) {
            event(new PublicPartnerRegistrationInitiated($p));

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

        if ($p->type_id == 8) {
            $p->position = $request->type;
        }

        $check = $p->save();


        if ($check) {
            $e = new ethics();

            $e->partner_id = $p->id;

            $e->save();

            Notification::route('mail', $request->email)->notify(new PartnerQuestionnaireNotification($p));
            event(new PartnerRegistrationInitiated($p));



            return response()->json(['message' => 'Business Partner Created'], 200);
        } else {

            return response()->json(['message' => 'Error Creating Business partner'], 500);
        }
    }

    public function PartnerQuestion(Request $request, $id)
    {
        if (!$request->hasValidSignature()) {
            return view('ethics.message')->with('success', false)->with('msg', "Form Expired");
        } else {

            $e = Partner::where('uuid', $id)->where('status', 1)->first();

            if ($e) {
                if ($e->type_id != 8) {
                    return view('ethics.partnerForm')->with('ethics', $e);
                } else {
                    return view('ethics.individualForm')->with('ethics', $e);
                }
            } else {
                return view('ethics.message')->with('success', true)->with('msg', "Form already Submitted");
            }
        }
    }

    public function partnerStore($id, PartnerForm  $request)
    {

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
            $p->org_type = $request->org_type;

            $incorp = $request->hasFile('incorp_file');
            if ($incorp) {
                $extension = $request->file('incorp_file')->extension();
                $incorp_file = $p->uuid . '/incorp/' . md5(date('Y-m-d H:i:s')) . '.' . $extension;
                Storage::disk('myDisk')->put($incorp_file, File::get($request->file('incorp_file')));
                $p->incorp_file = $incorp_file;
            }


            $p->status = 2;

            $p->question_submitted_on = Carbon::now();

            $p->subsidiary = $request->subsidiary;
            $p->employee = $request->employee;
            $p->revenue = $request->revenue;
            $p->insolvency = $request->insolvency;

            $check = $p->save();

            $e = Ethics::where('partner_id', $p->id)->where('active', 1)->first();

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
                event(new PartnerQuestionnaireSubmitted($p));
                $file4 = $request->signature;
                if ($file4) {
                    $file = $request->signature;
                    $file = str_replace('data:image/png;base64,', '', $file);
                    $file = str_replace(' ', '+', $file);
                    $fileData = base64_decode($file);

                    $filename = $p->uuid . '/signature.png';
                    $public = 'signature/' . $p->uuid . '.png';

                    Storage::disk('myDisk')->put($filename, $fileData);
                    Storage::disk('public')->put($public, $fileData);
                }
                return view('ethics.message')->with('success', true)->with('msg', "Form Submitted Successfully");
            } else {
                return view('ethics.message')->with('success', false)->with('msg', "Something went wrong");
            }
        } else {
            return view('ethics.message')->with('success', false)->with('msg', "Something went wrong");
        }
    }
    //Individual Partner Form
    public function individualPartnerStore($id, IndividualFormRequest $request)
    {


        $p = Partner::where('uuid', $id)->where('status', 1)->first();
        if ($p) {
            $p->name = $request->name;
            $p->address = $request->address;
            $p->cop_num = $request->cop_num;
            $p->cop_juri = $request->cop_juri;
            $p->doi = $request->doi;

            $p->status = 2;
            $p->question_submitted_on = Carbon::now();
            $p->revenue = $request->revenue;
            $p->tp = $request->tp;
            $p->license = $request->license;
            // $p->org_type=$request->org_type;

            $incorp = $request->hasFile('incorp_file');
            if ($incorp) {
                $extension = $request->file('incorp_file')->extension();
                $incorp_file = $p->uuid . '/incorp/' . md5(date('Y-m-d H:i:s')) . '.' . $extension;
                Storage::disk('myDisk')->put($incorp_file, File::get($request->file('incorp_file')));
                $p->incorp_file = $incorp_file;
            }

            $check = $p->save();

            if ($check) {

                $e = Ethics::where('partner_id', $p->id)->where('active', 1)->first();

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
                //$e->p_des = $request->p_des;


                $file3 = $request->hasFile('statement_file');
                if ($file3) {
                    $extension = $request->file('statement_file')->extension();
                    $statement_file = $p->uuid . '/statement/' . md5(date('Y-m-d H:i')) . '.' . $extension;
                    Storage::disk('myDisk')->put($statement_file, File::get($request->file('statement_file')));
                    $e->statement_file = $statement_file;
                }



                $check = $e->save();

                if ($check) {
                    $file4 = $request->signature;
                    if ($file4) {
                        $file = $request->signature;
                        $file = str_replace('data:image/png;base64,', '', $file);
                        $file = str_replace(' ', '+', $file);
                        $fileData = base64_decode($file);

                        $filename = $p->uuid . '/signature.png';

                        $public = 'signature/' . $p->uuid . '.png';

                        Storage::disk('myDisk')->put($filename, $fileData);
                        Storage::disk('public')->put($public, $fileData);
                    }
                    event(new PartnerQuestionnaireSubmitted($p));
                    return view('ethics.message')->with('success', true)->with('msg', "Form Submitted Successfully");
                } else {
                    return view('ethics.message')->with('success', false)->with('msg', "Something went wrong");
                }
            } else {
                return view('ethics.message')->with('success', false)->with('msg', "Something went wrong");
            }
        } else {
            return view('ethics.message')->with('success', false)->with('msg', "Something went wrong");
        }
    }

    public function view(Request $request)
    {
        $user = Auth::user();

        $mode = $request->input('mode', 0);

        if ($user->isAdmin() || $user->can('View All Records')) {
            $partner = Partner::with('type')->when($mode == 2, function ($query) {
                return $query->where('status', 7);
            })->when($mode == 1, function ($query) {
                return $query->where('status', 6)->where('is_renew', 0)->where('can_renew', 1);
            })->orderBy('updated_at','desc')->take(300)->get();
        } else if ($user->can('View Entity Records')) {
            $partner = Partner::whereIn('project_id', $user->getProjectsIDs())->with('type')->when($mode == 2, function ($query) {
                return $query->where('status', 7);
            })->when($mode == 1, function ($query) {
                return $query->where('status', 6)->where('is_renew', 0)->where('can_renew', 1);
            })->orderBy('updated_at', 'desc')->take(300)->get();
        } else if ($user->can('View Own Records')) {
            $partner = Partner::
            where('cuser', $user->id)->orderBy('created_at', 'desc')->with('type')->when($mode == 2, function ($query) {
                return $query->where('status', 7);
            })->when($mode == 1, function ($query) {
                return $query->where('status', 6)->where('is_renew', 0)->where('can_renew', 1);
            })->take(300)->get();
        } else {
            return response()->json(['message' => 'Error in Permissions'], 500);
        }

        if ($partner->count() > 0) {
            $data = [];
            $x = 1;
            foreach ($partner as $p) {
                $data[] = [
                    'x' => $x,
                    'id' => $p->uuid,
                    'name' => $p->name,
                    'status' => $p->getStatus(),
                    'type' => $p->getType(),
                    // 
                ];
                $x++;
            }
            return response()->json($data, 200);
        } else {
            return response()->json(['message' => 'No Data Found'], 500);
        }
    }

    public function detail(Request $request)
    {
        $user = Auth::user();
        $e = Partner::where('uuid', $request->id)->with('ethics')->with('arrangements')->with('type')->first();
        
        $check=$user->can('view', $e);
        
        if ($e && $check) {
            //getting Dates
            $doi = $e->doi == null ? '' : $e->doi->toFormattedDateString();
            $cdo_date = $e->ethics->cdo_date == null ? '' :  $e->ethics->cdo_date->toFormattedDateString();
            $pm_at = $e->ethics->pm_at == null ? '' : $e->ethics->pm_at->toFormattedDateString();
            $comp_at = $e->ethics->ims_at == null ? '' : $e->ethics->ims_at->toFormattedDateString();
            $valid_till = is_null($e->due_on) ? '' : $e->due_on->toFormattedDateString();

            //Get Appvoers
            $groupUsers = $e->status == 3 ? User::getApprover('Group Compliance Approver') : [];
            $committeUsers = $e->status == 8 ? User::getApprover('Committee Compliance Approver') : [];
            $headUsers = $e->status == 8 ? User::getApprover('Entity Head') : [];


            //Streamlining files
            $policy_file = !is_null($e->ethics->policy_file) ? route('ethics.file', ['file' => $e->ethics->policy_file, 'name' => 'Partner Policy']) : '';
            $statement_file = !is_null($e->ethics->statement_file) ? route('ethics.file', ['file' => $e->ethics->statement_file, 'name' => 'Partner statement']) : '';
            $cert_file = !is_null($e->ethics->cert_file) ? route('ethics.file', ['file' => $e->ethics->cert_file, 'name' => 'Partner cert']) : '';
            $lexis_file = !is_null($e->ethics->lexis_file) ? route('ethics.file', ['file' => $e->ethics->lexis_file, 'name' => 'Partner Lexis File']) : '';
            $screenshot_file = !is_null($e->ethics->screenshot_file) ? route('ethics.file', ['file' => $e->ethics->screenshot_file, 'name' => 'Partner screenshot']) : '';
            $need_file = !is_null($e->ethics->need_file) ? route('ethics.file', ['file' => $e->ethics->need_file, 'name' => 'Partner Need Validation']) : '';
            $incorp_file = !is_null($e->incorp_file) ? route('ethics.file', ['file' => $e->incorp_file, 'name' => 'Partner Incorporation']) : '';

            $files = [
                'policy_file' => $policy_file,
                'statement_file' => $statement_file,
                'cert_file' => $cert_file,
                'lexis_file' => $lexis_file,
                'screenshot_file' => $screenshot_file,
                'need_file' => $need_file,
                'incorp_file' => $incorp_file
            ];

            //Renewal Process
            $renew = $e->is_renew;
            if ($renew) {
                $renew_data = [
                    'pcountry' => $e->getCountry($e->ethics->renew_pcountry),
                    'pcpi' => $e->ethics->renew_pcpi,
                    'contract' => $e->ethics->renew_contract,
                    'phase' => $e->getPhase($e->ethics->renew_phase),
                    'scope' => $e->ethics->renew_scope,
                    'cdo' => [
                        'value' => $e->ethics->renew_cdo,
                        'yn' => $e->yn($e->ethics->renew_cdo),
                        'date' => $e->getTime($e->ethics->renew_cdo_date)
                    ],
                    'mutual' => $e->mutual($e->ethics->renew_mutual),
                    'recomm' => $e->yn($e->ethics->renew_recomm),
                    'pm_by' => $e->getUsername($e->ethics->renew_pm_by),
                    'pm_at' => $e->getTime($e->ethics->renew_pm_at),
                    'search' => $e->search($e->ethics->renew_search),
                    'breach' => $e->yn($e->ethics->renew_breach),
                    'flag' => $e->ethics->renew_flag,
                    'mitigation' => $e->ethics->mitigation,
                    'screenshot_file' => !is_null($e->ethics->renew_screenshot_file) ? route('ethics.file', ['file' => $e->ethics->renew_screenshot_file, 'name' => 'Partner screenshot']) : '',
                    'lexis_file' => !is_null($e->ethics->renew_lexis_file) ? route('ethics.file', ['file' => $e->ethics->renew_lexis_file, 'name' => 'Partner Lexis Document']) : '',
                    'integrity' => $e->ethics->renew_integrity,
                    'decision' => $e->ethics->decisionVal($e->ethics->renew_ims_decision),
                    'reason' => $e->ethics->renew_ims_reason,
                    'condition' => $e->ethics->renew_ims_condition,
                    'remarks' => $e->ethics->renew_ims_add,
                    'lexis_file' => $e->ethics->renew_lexis_file,
                    'ims_by' => $e->getUsername($e->ethics->renew_ims_by),
                    'ims_at' => $e->getTime($e->ethics->renew_ims_at)
                ];
            }

            //Escalated Approvals

            $l1_val = !is_null($e->ethics->l1_by);
            $l1_data = [];
            if ($l1_val) {
                $l1_at = $e->ethics->l1_at->toFormattedDateString();
                $l1_data = [
                    'l1_decision' => [
                        'value' => $e->ethics->l1_decision,
                        'yn' => $e->ethics->decisionVal($e->ethics->l1_decision),
                    ],
                    'l1_condition' => $e->ethics->l1_condition,
                    'l1_reason' => $e->ethics->l1_reason,
                    'l1_add' => $e->ethics->l1_add,
                    'l1_by' => $e->getUsername($e->ethics->l1_by),
                    'l1_at' => $l1_at
                ];
            }

            $l2_val = !is_null($e->ethics->l2_by);
            $l2_data = [];
            if ($l2_val) {
                $l2_at = $e->ethics->l2_at->toFormattedDateString();
                $l2_data = [
                    'l2_decision' => [
                        'value' => $e->ethics->l2_decision,
                        'yn' => $e->ethics->decisionVal($e->ethics->l2_decision),
                    ],
                    'l2_condition' => $e->ethics->l2_condition,
                    'l2_reason' => $e->ethics->l2_reason,
                    'l2_add' => $e->ethics->l2_add,
                    'l2_by' =>  $e->getUsername($e->ethics->l2_by),
                    'l2_at' => $l2_at
                ];
            }

            //Pursuance

            $is_pursuance=isset($e->ethics->head_assign);
            $pursuance=[];
            if($is_pursuance){

               $pursuance=[ 
                   'assigned'=>$e->getUsername($e->ethics->head_assign),
                    'by'=>$e->getUsername($e->ethics->head_by),
                    'at'=>$e->getTime($e->ethics->head_at),
                    'decision'=>$e->ethics->head_decision==1?'Yes':'No',
                    'reason'=>$e->ethics->head_reason,
                ];
            }

            //Blacklisting Details
            $blacklistDetail = $e->status == 7 ? [
                'blacklist_by' => $e->getUsername($e->blacklist_by),
                'blacklist_on' => $e->getTime($e->blacklist_on),
                'blacklist_reason' => $e->blacklist_reason,
                'blacklist_till' => $e->getTime($e->blacklist_till),
            ] : [];
            $downloadQues = null;
            $exists = Storage::disk('myDisk')->exists($e->uuid . '/questionnaire.pdf');
            if ($exists) {
                $downloadQues = route('ethics.file', ['file' => $e->uuid . '/questionnaire.pdf', 'name' => 'Questionnaire']);
                //$downloadQues=route('ethics.pdfDownload',['id'=>$e->uuid,'form'=>1]);
            }
            $downloadForm = null;
            $exists = Storage::disk('myDisk')->exists($e->uuid . '/BPForm.pdf');
            if ($exists) {
                $downloadForm = route('ethics.file', ['file' => $e->uuid . '/BPForm.pdf', 'name' => 'BPForm']);
                //$downloadForm=route('ethics.pdfDownload',['id'=>$e->uuid,'form'=>2]);
            }
            $downloadRenew = null;
            $exists = Storage::disk('myDisk')->exists($e->uuid . '/renewal.pdf');
            if ($exists) {
                $downloadRenew = route('ethics.file', ['file' => $e->uuid . '/renewal.pdf', 'name' => 'Renewal']);
                //$downloadForm=route('ethics.pdfDownload',['id'=>$e->uuid,'form'=>2]);
            }

            $data = [
                'downloadQues' => $downloadQues,
                'downloadForm' => $downloadForm,
                'downloadRenew' => $downloadRenew,
                'files' => $files,
                'unique' => $e->uuid,
                'org_type' => $e->org_type,
                'q_submission' => $e->q_submission,
                'name' => $e->name,
                'type' => ['value' => $e->type_id, 'name' => $e->getType()],
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
                'tp' => $e->tp,

                'policy' => [
                    'value' => $e->ethics->policy,
                    'yn' => $e->policy($e->ethics->policy),
                    'file' => $e->ethics->policy_file,
                    'p1' => $e->policy($e->ethics->p1),
                    'p2' => $e->policy($e->ethics->p2),
                    'p3' => $e->policy($e->ethics->p3),
                    'p4' => $e->policy($e->ethics->p4),
                    'p5' => $e->policy($e->ethics->p5),
                ],
                'person' => [
                    'value' => $e->ethics->person,
                    'yn' => $e->yn($e->ethics->person),
                    'detail' => $e->ethics->person_detail,
                ],
                'q' => [
                    'q_detail' => $e->ethics->q_detail,
                    'q1' => $e->yn($e->ethics->q1),
                    'q2' => $e->yn($e->ethics->q2),
                    'q3' => $e->yn($e->ethics->q3),
                    'q4' => $e->yn($e->ethics->q4),
                    'q5' => $e->yn($e->ethics->q5),
                ],
                'r_detail' => $e->ethics->r_detail,
                'benefit_detail' => $e->ethics->benefit_detail,
                's_detail' => $e->ethics->s_detail,
                'cert' => [
                    'yn' => $e->yn($e->ethics->t),
                    'file' => $e->ethics->certi_file
                ],

                'p_name' => $e->ethics->p_name,
                'p_des' => $e->ethics->p_des,
                'submitted_on' => $e->getTime($e->question_submitted_on),

                'scope' => $e->ethics->scope,
                'entity' => $e->project->name,
                'contract' => $e->ethics->contract,
                'spot' => $e->spot_code,
                'bview' => $e->bview,
                'phase' => $e->ethics->getPhase(),
                'pcountry' => $e->getCountry($e->ethics->pcountry),
                'pcpi' => $e->ethics->pcpi,
                'country' => $e->getCountry($e->country_id),
                'cpi' => $e->cpi,
                'cdo' => [
                    'value' => $e->ethics->cdo,
                    'yn' => $e->yn($e->ethics->cdo),
                    'date' => $cdo_date
                ],
                'mutual' => $e->mutual($e->ethics->mutual),
                'recomm' => $e->yn($e->ethics->recomm),
                'search' => $e->search($e->ethics->search),
                'satis' => $e->yn($e->ethics->satis),
                'need' => $e->yn($e->ethics->need),
                'practice' => $e->yn($e->ethics->practice),
                'practice_detail' => $e->ethics->practice_detail,
                'flag' => $e->ethics->flag,
                'mitigation' => $e->ethics->mitigation,
                'pm_by' =>  $e->getUsername($e->ethics->pm_by),
                'pm_at' => $pm_at,

                'integrity' => $e->yn($e->ethics->integrity),
                'flag_action' => $e->ethics->flag_action,
                'decision' => [
                    'value' => $e->ethics->decision,
                    'yn' => $e->ethics->decisionVal($e->ethics->decision),
                ],
                'condition' => $e->ethics->condition,
                'reason' => $e->ethics->reason,
                'add' => $e->ethics->add,
                //'renewal' => $e->renewals()->count(),
                'comp_by' => $e->getUsername($e->ethics->ims_by),
                'comp_at' => $comp_at,

                'reg' => $e->reg,
                'status_name' => $e->getStatus(),
                'validity' => $valid_till,
                'searches' => $e->searches->count(),

                'audit_trial' => $e->getaudits->count(),
                'groupUsers' => $groupUsers,
                'committeUsers' => $committeUsers,
                'headUsers' => $headUsers,


                'ims_decision' => [
                    'value' => $e->ethics->ims_decision,
                    'yn' => $e->ethics->decisionVal($e->ethics->ims_decision),
                ],
                'ims_condition' => $e->ethics->ims_condition,
                'ims_reason' => $e->ethics->ims_reason,
                'ims_add' => $e->ethics->ims_add,

                'l1' => $l1_data,
                'l2' => $l2_data,
                'blacklistDetail' => $blacklistDetail,


                'finance' => [
                    'remark' => $e->ethics->finance_remarks,
                    'by' => $e->getUsername($e->ethics->finance_approved_by),
                    'on' => $e->getTime($e->ethics->finance_approved_on)
                ],

                'is_renew' => $renew,

                'arrangements' => $e->arrangements->count(),

                //Approver conditions
                'pmApprover' => $user->can('pmApprove', $e),
                'imsApprover' => $user->can('imsApprove', $e) && $e->status == 3,
                'l1Approver' => $user->can('l1Approve', $e) && $e->status == 8,
                'l2Approver' => $user->can('l2Approve', $e) && $e->status == 9,
                'financeReviewer' => $user->can('financeReview', $e),
                'renew_partner' => ($user->can('Renew Partner') && $e->status > 3 && $e->status < 7  && $e->status != 5 && now()->diffInDays($e->due_on, false) < 10 && now()->diffInDays($e->due_on, false) > - (config('ethics.renewal_expiry', 90)) && !$e->is_renew),
                'pursuanceApprover'=>($user->can('pursuanceApprove',$e)),
                'canBlacklist'=>($user->can('blackListPartner',$e)),
                'canWhitelist'=>($user->can('whiteListPartner',$e)),
                'renewApprover' => $user->can('renewApprove', $e),

            ];

            if($is_pursuance){
                $data['pursuance'] = $pursuance;
            }

            if ($renew) {
                $data['renew'] = $renew_data;
            }

            if ($e->arrangements->count() > 0) {
                $data['arrangementData'] = $e->getArrangements();
            }



            if ($e) {
                return response()->json($data, 200);
            } else {
                return response()->json(['message' => 'Record Not found'], 500);
            }
        } else {
            return response()->json(['message' => 'Record Not found'], 500);
        }
    }

    public function storePmForm(Request $request)
    {
        //storeApproveForm
        
        $user = Auth::user();
        $id = $request->unique;
        $e = Partner::where('uuid', $id)->where('status', 2)->first();


        if ($e) {
            DB::transaction(function () use ($user, $request, $e) {
                $e->status = 3;
                $e->spot_code=$request->spot;
                $e->bview = $request->bview;
                $e->save();

                $p = Ethics::where('partner_id', $e->id)->where('active', 1)->first();
                $p->contract = $request->contract;
                $p->phase = $request->phase;
                $p->scope = $request->scope;
                $p->cdo = $request->cdo;
                if ($request->dcdo) {
                    $p->cdo_date = $request->dcdo;
                }
                $p->mutual = $request->mutual;
                $p->recomm = $request->recomm;
                $p->pcountry = $request->pcountry;
                $p->pcpi = $request->pcpi;
                $p->search = $request->search;
                

                $file = $request->hasFile('screenshot_file');
                if ($file) {
                    $extension = $request->file('screenshot_file')->extension();
                    $search_file = $e->uuid . '/search/' . md5(date('Y-m-d H:i')) . '.' . $extension;
                    Storage::disk('myDisk')->put($search_file, File::get($request->file('screenshot_file')));
                    $p->screenshot_file = $search_file;
                }

                $file = $request->hasFile('need_file');
                if ($file) {
                    $extension = $request->file('need_file')->extension();
                    $need_file = $e->uuid . '/need/' . md5(date('Y-m-d H:i')) . '.' . $extension;
                    Storage::disk('myDisk')->put($need_file, File::get($request->file('need_file')));
                    $p->need_file = $need_file;
                }

                if ($request->satis) {
                    $re = $request->satis;
                } else {
                    $re = null;
                }
                $p->satis = $re;
                $p->practice = $request->practice;
                $p->practice_detail = $request->practice_detail;

                $p->need = $request->need;
                $p->flag = $request->flag;
                $p->mitigation = $request->mitigations;

                $p->pm_by = $user->id;
                $p->pm_at = Carbon::now();

                $p->ims_assign = $request->ims_assign;

                if (!is_null($request->fm_assign)) {
                    $p->finance_assigned = $request->fm_assign;
                }


                $p->save();
            });


            event(new PmApproved($e));
            return response()->json(['message' => 'Business Partner Approved']);
        } else {
            return response()->json(['message' => 'Something went wrong.Category 2'], 500);
        }
    }

    public function compForm(Request  $request)
    {
        //CompForm
        $user = Auth::user();

        $e = Partner::where('uuid', $request->unique)->first();
        if ($e) {

            $exception = DB::transaction(function () use ($request, $user, $e) {
                if ($request->decision == 1 || $request->decision == 2) {
                    $e->status = 4;
                    $e->approved_on = Carbon::now();
                    $e->due_on = Carbon::now()->addMonths(24);
                    $e->approved_by = Auth::id();
                    createPDF::dispatch($e->id);
                } else {
                    $e->status = 8;
                }
                $e->save();

                $p = Ethics::where('partner_id', $e->id)->where('active', 1)->first();
                $p->integrity = $request->integrity;
                $file = $request->hasFile('lexis_file');
                if ($file) {
                    $extension = $request->file('lexis_file')->extension();
                    $lexis_file = $e->uuid . '/lexis/' . md5(date('Y-m-d H:i')) . '.' . $extension;
                    Storage::disk('myDisk')->put($lexis_file, File::get($request->file('lexis_file')));
                    $p->lexis_file = $lexis_file;
                }
                $p->flag = $request->flag;
                $p->mitigation = $request->mitigation;
                $p->flag_action = $request->flag_action;
                $p->decision = $request->decision;

                $p->ims_decision = $request->decision;

                $p->reason = $request->reason;
                $p->ims_reason = $request->reason;

                if ($request->decision == 0) {
                    $p->l1_assign = $request->approver;
                    $l1_approver = User::where('id', $request->approver)->first();
                    // Log::info('Mail to' . $l1_approver->email);
                    Notification::route('mail', $l1_approver->email)->notify(new ApprovalNotification($e));
                } else {
                    //Trigger Event
                    event(new PartnerRegistered($e));
                }


                if ($request->add) {
                    $p->add = $request->add;
                    $p->ims_add = $request->add;
                }

                if ($request->condition) {
                    $p->condition = $request->condition;
                    $p->ims_condition = $request->condition;
                }

                $p->ims_by = Auth::id();
                $p->ims_at = Carbon::now();
                $p->save();

                if ($request->decision == 1 || $request->decision == 2) {
                    //generating Registration
                    $count = EthicsController::generateReg($e);
                    $e->rno = $count[0];
                    $e->reg = $count[1];
                    $e->save();

                    //Filling Renewal form
                    $r = new Renew();
                    $r->partner_id = $e->id;
                    $r->integrity = $request->integrity;
                    $r->flag_action = $request->flag_action;
                    $r->decision = $request->decision;
                    if ($request->condition) {
                        $p->condition = $request->condition;
                    }
                    $r->reason = $request->reason;
                    if ($request->add) {
                        $r->add = $request->add;
                    }
                    $r->user_id = Auth::id();
                    $r->initial = 1;
                    $r->save();
                }
            });

            //event(new PartnerRegistered($e));
            $check = is_null($exception) ? true : false;

            if ($check) {
                event(new ComplianceDecision($e));
                return response()->json(['success' => true, 'message' => 'Decision Registerd.'], 200);
            } else {
                return response()->json(['success' => false, 'message' => 'Something went wrong'], 500);
            }
        } else {
            return response()->json(['success' => false, 'message' => 'Something went wrong'], 500);
        }
    }

    public function escalationForm(Request  $request)
    {
        $user = Auth::user();

        $e = Partner::where('uuid', $request->unique)->first();
        if ($e) {

            $exception = DB::transaction(function () use ($request, $user, $e) {
                $oldStatus = $e->status;
                if ($request->decision == 1 || $request->decision == 2) {
                    $e->status = 4;
                    $e->approved_on = Carbon::now();
                    $e->due_on = Carbon::now()->addMonths(24);
                    $e->approved_by = Auth::id();
                    createPDF::dispatch($e->id);
                } else {
                    if ($e->status == 8) {
                        $e->status = 11; //Changes her to 11
                    } else {
                        $e->status = 5;
                        $e->approved_on = Carbon::now();
                        $e->approved_by = Auth::id();
                    }
                }
                $e->save();

                $p = Ethics::where('partner_id', $e->id)->where('active', 1)->first();

                if ($oldStatus == 8) {
                    $p->decision = $request->decision;
                    $p->l1_decision = $request->decision;
                    $p->reason = $request->reason;
                    $p->l1_reason = $request->reason;
                    if ($request->decision == 0) {
                        $p->l2_assign = $request->approver;
                        $p->head_assign = $request->head;
                        $head_approver = User::where('id', $request->head)->first();
                        Log::info('Mail for Pursuance Approval to' . $head_approver->email);
                        Notification::route('mail', $head_approver->email)->notify(new ApprovalNotification($e));
                    } else {
                        //Trigger Event
                        event(new PartnerRegistered($e));
                    }

                    if ($request->add) {
                        $p->add = $request->add;
                        $p->l1_add = $request->add;
                    }

                    if ($request->condition) {
                        $p->condition = $request->condition;
                        $p->l1_condition = $request->condition;
                    }

                    $p->l1_by = Auth::id();
                    $p->l1_at = Carbon::now();
                } else {
                    $p->decision = $request->decision;
                    $p->l2_decision = $request->decision;
                    $p->reason = $request->reason;
                    $p->l2_reason = $request->reason;

                    if ($request->add) {
                        $p->add = $request->add;
                        $p->l2_add = $request->add;
                    }

                    if ($request->condition) {
                        $p->condition = $request->condition;
                        $p->l2_condition = $request->condition;
                    }

                    //Trigger Event
                    event(new PartnerRegistered($e));

                    $p->l2_by = Auth::id();
                    $p->l2_at = Carbon::now();
                }

                $p->save();


                if ($request->decision == 1 || $request->decision == 2 || $e->status == 5) {
                    //generating Registration
                    $count = EthicsController::generateReg($e);
                    $e->rno = $count[0];
                    $e->reg = $count[1];
                    $e->save();



                    //Filling Renewal form
                    $r = new Renew();
                    $r->partner_id = $e->id;
                    $r->integrity = $p->integrity;
                    $r->flag_action = $p->flag_action;
                    $r->decision = $request->decision;
                    if ($request->condition) {
                        $p->condition = $request->condition;
                    }
                    $r->reason = $request->reason;
                    if ($request->add) {
                        $r->add = $request->add;
                    }
                    $r->user_id = Auth::id();
                    $r->initial = 1;
                    $r->save();
                }
            });


            event(new ComplianceDecision($e));
            //


            $check = is_null($exception) ? true : false;

            if ($check) {
                return response()->json(['success' => true, 'message' => 'Decision Registerd.'], 200);
            } else {
                return response()->json(['success' => false, 'message' => 'Something went wrong'], 500);
            }
        } else {
            return response()->json(['success' => false, 'message' => 'Something went wrong'], 500);
        }
    }

    public function pursuance(Request  $request)
    {
        $user = Auth::user();

        $e = Partner::where('uuid', $request->unique)->first();
        if ($e) {
            $p = Ethics::where('partner_id', $e->id)->where('active', 1)->first();
            if ($request->decision == 0) {
                $e->status = 5;
                $e->approved_on = Carbon::now();
                $e->approved_by = Auth::id();
            } else {
                $e->status = 9;
                $l2_approver = User::where('id', $p->l2_assign)->first();
                Log::info('Mail to' . $l2_approver->email);
                Notification::route('mail', $l2_approver->email)->notify(new ApprovalNotification($e));
            }

            $p->head_by = $user->id;
            $p->head_at = Carbon::now();
            $p->head_decision = $request->decision;
            $p->head_reason = $request->reason;

            $e->save();
            $check = $p->save();

            if ($request->decision == 0) {
                $count = EthicsController::generateReg($e);
                    $e->rno = $count[0];
                    $e->reg = $count[1];
                    $e->save();



                    //Filling Renewal form
                    $r = new Renew();
                    $r->partner_id = $e->id;
                    $r->integrity = $p->integrity;
                    $r->flag_action = $p->flag_action;
                    $r->decision = $request->decision;
                    $r->user_id = Auth::id();
                    $r->initial = 1;
                    $r->save();

            }

            if ($check) {
                event(new PartnerRegistered($e));
                return response()->json(['success' => true, 'message' => 'Decision Registerd.'], 200);
            } else {
                return response()->json(['success' => false, 'message' => 'Something went wrong'], 500);
            }
        } else {
            return response()->json(['success' => false, 'message' => 'Something went wrong'], 500);
        }
    }

    public static function generateReg(Partner $p)
    {
        $calc_month = $p->created_at->format('m');
        $calc_year = $p->created_at->format('Y');
        $month = Partner::withTrashed()->whereRaw("to_char(created_at,'MM')='$calc_month'")->whereRaw("to_char(created_at,'YYYY')='$calc_year'")->whereNotNull('rno')->where('project_id', $p->project_id)->orderBy('rno', 'desc')->get();
        Log::info('message');
        $value = 1;
        if ($month->count() > 0) {
            $val = $month->first();
            $rno = $val->rno + 1;
            $value = $rno;
        }

        $code = $p->project->code;

        $y = Carbon::createFromFormat('Y-m-d H:i:s', $p->created_at)->year;
        $m = Carbon::createFromFormat('Y-m-d H:i:s', $p->created_at)->shortEnglishMonth;

        $code = $y . '/' . strtoupper($code) . '/' . strtoupper($m) . '/' . sprintf('%03u', $value);

        return [$value, $code];
    }

    public function searchResults(Request $request)
    {
        $user = Auth::user();
        $e = Partner::where('uuid', $request->id)->with('searches')->first();


        $log = [];
        $x = 1;
        foreach ($e->searches as $o) {
            $res = '<a target="_blank" href="' . $o->links . '">' . $o->getLink() . '</a>';

            $log[] = [
                'id' => $x,
                'kw' => $o->criteria,
                'href' => $o->links,
                'link' => $o->getLink(),
                'date' => $o->created_at->toFormattedDateString(),

            ];
            $x = $x + 1;
        }

        return response()->json($log, 200);
    }

    public function auditResults(Request $request)
    {
        $user = Auth::user();
        $e = Partner::where('uuid', $request->id)->with('getaudits')->first();

        $log = [];
        $x = 1;
        foreach ($e->getaudits as $o) {
            $name = '';
            if ((!is_null($o->user_id) && $o->user_id != 0)) {
                $name = $e->getUsername($o->user_id);
            } else if ($o->user_id == 0 && !is_null($o->user_id)) {
                $name = 'System';
            } else {
                $name = 'Partner Representative';
            }

            $date = $o->created_at->isoFormat('D MMM  YYYY, HH:mm');
            $log[] = [
                'id' => $x,
                'user' => $name,
                'action' => $o->action,
                'date' => $date,
            ];
            $x = $x + 1;
        }

        return response()->json($log, 200);
    }

    public function resendNotification(Request $request)
    {


        $p = Partner::where('uuid', $request->id)->where('status', 1)->first();
        if ($p) {
            Notification::route('mail', $p->email)->notify(new PartnerQuestionnaireNotification($p));

            return response()->json(['success' => true, 'message' => 'Notification Resent.'], 200);
        }

        return response()->json(['message' => 'Notification Failed.'], 500);
    }

    public function file(Request $request)
    {

        // dd($request->input('file'));

        $name = 'fileName';

        if ($request->has('name')) {
            $name = $request->input('name');
        }

        $ext = File::extension($request->input('file'));


        if ($ext == 'pdf') {
            $content_types = 'application/pdf';
        } elseif ($ext == 'doc') {
            $content_types = 'application/msword';
        } elseif ($ext == 'docx') {
            $content_types = 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
        } elseif ($ext == 'xls') {
            $content_types = 'application/vnd.ms-excel';
        } elseif ($ext == 'xlsx') {
            $content_types = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
        } elseif ($ext == 'txt') {
            $content_types = 'application/octet-stream';
        } elseif ($ext == 'png') {
            $content_types = 'images/png';
        } elseif ($ext == 'jpeg') {
            $content_types = 'images/jpeg';
        } else {
            return abort(502);
        }

        $headers = [
            'Content-Type' => $content_types,
        ];

        ob_end_clean();

        return Storage::disk('myDisk')->download($request->input('file'), $name . '.' . $ext, $headers);
    }

    public function entityData()
    {
        $entity = Project::getDataArray();

        return response()->json($entity, 200);
    }

    public function questionnaireNotSubmitted(Request $request)
    {

        $p = Partner::where('uuid', $request->id)->where('status', 1)->first();
        if ($p) {
            $p->q_submission = 0;
            $p->status = 2;
            $check = $p->save();

            if ($check) {
                return response()->json(['success' => true, 'message' => 'Sucessfully Updated'], 200);
            } else {
                return response()->json(['message' => 'Process Failed.'], 500);
            }
        }

        return response()->json(['message' => 'Process Failed.'], 500);
    }

    public function deletePartner(Request $request)
    {

        $p = Partner::where('uuid', $request->id)->first();

        if ($p) {
            $id = $p->id;
            $p->delete();
            $p->save();
            $e = Ethics::where('partner_id', $id)->where('active', 1)->first()->delete();
            return response()->json(['success' => true, 'message' => 'Sucessfully Deleted'], 200);
        }

        return response()->json(['message' => 'Process Failed.'], 500);
    }

    public function financeReview(Request $request)
    {

        $p = Partner::where('uuid', $request->unique)->first();

        if ($p) {
            $e = Ethics::where('partner_id', $p->id)->where('active', 1)->first();
            $e->finance_remarks = $request->reason;
            $e->finance_approved_by = Auth::id();
            $e->finance_approved_on = Carbon::now();
            $e->save();

            return response()->json(['success' => true, 'message' => 'Sucessfully Reviewed'], 200);
        }

        return response()->json(['message' => 'Something went wrong.'], 500);
    }

    public function pendingApproval()
    {
        $user = Auth::user();

        if ($user->isAdmin() || $user->can('View All Records')) {
            $partner = Partner::orderBy('created_at', 'desc')->whereNotIn('status', [1, 4, 5, 6, 7])->with('type')->with('ethics')->take(100)->get();
        } else if ($user->can('View Entity Records')) {
            $partner = Partner::whereIn('project_id', $user->getProjectsIDs())->whereNotIn('status', [1, 4, 5, 6, 7])->with('ethics')->with('type')->orderBy('created_at', 'desc')->take(100)->get();
        } else if ($user->can('View Own Records')) {
            $partner = Partner::where('cuser', $user->id)->orderBy('created_at', 'desc')->whereNotIn('status', [1, 4, 5, 6, 7])->with('ethics')->with('type')->take(100)->get();
        } else {
            return response()->json(['message' => 'Error in Permissions'], 500);
        }

        if ($partner->count() > 0) {
            $data = [];
            $x = 1;

            foreach ($partner as $p) {
                $go = false;
                if ($p->status == 2 && $p->cuser == $user->id) {
                    $go = true;
                } elseif ($p->status == 3 && $p->ethics->ims_assign == $user->id) {
                    $go = true;
                } elseif ($p->status == 8 && $p->ethics->l1_assign == $user->id) {
                    $go = true;
                } elseif ($p->status == 9 && $p->ethics->l2_assign == $user->id) {
                    $go = true;
                } elseif ($p->status == 11 && $p->ethics->head_assign == $user->id) {
                    $go = true;
                }elseif ($p->status == 10 && $p->renew_assign == $user->id) {
                    $go = true;
                } elseif ($p->ethics->finance_assigned == $user->id) {
                    $go = true;
                }

                if ($go) {
                    $data[] = [
                        'x' => $x,
                        'id' => $p->uuid,
                        'name' => $p->name,
                        'status' => $p->getStatus(),
                        'type' => $p->getType(),
                    ];
                    $x++;
                }
            }
            return response()->json($data, 200);
        } else {
            return response()->json(['message' => 'No Data Found'], 500);
        }
    }

    public function viewFiles(Request $request)
    {

        $e = Partner::where('uuid', $request->id)->with('ethics')->with('arrangements')->with('type')->first();

        if ($e) {
            //Streamlining files
            $policy_file = !is_null($e->ethics->policy_file) ? route('ethics.file', ['file' => $e->ethics->policy_file, 'name' => 'Partner Policy']) : '';
            $statement_file = !is_null($e->ethics->statement_file) ? route('ethics.file', ['file' => $e->ethics->statement_file, 'name' => 'Partner statement']) : '';
            $cert_file = !is_null($e->ethics->cert_file) ? route('ethics.file', ['file' => $e->ethics->cert_file, 'name' => 'Partner cert']) : '';
            $lexis_file = !is_null($e->ethics->lexis_file) ? route('ethics.file', ['file' => $e->ethics->lexis_file, 'name' => 'Partner Lexis File']) : '';
            $screenshot_file = !is_null($e->ethics->screenshot_file) ? route('ethics.file', ['file' => $e->ethics->screenshot_file, 'name' => 'Partner screenshot']) : '';
            $need_file = !is_null($e->ethics->need_file) ? route('ethics.file', ['file' => $e->ethics->need_file, 'name' => 'Partner Need Validation']) : '';
            $incorp_file = !is_null($e->incorp_file) ? route('ethics.file', ['file' => $e->incorp_file, 'name' => 'Partner Incorporation']) : '';
            $renew_screenshot_file = !is_null($e->ethics->renew_screenshot_file) ? route('ethics.file', ['file' => $e->ethics->renew_screenshot_file, 'name' => 'Partner screenshot']) : '';
            $renew_lexis_file = !is_null($e->ethics->renew_lexis_file) ? route('ethics.file', ['file' => $e->ethics->renew_lexis_file, 'name' => 'Partner Lexis Document']) : '';

            $files = [
                'incorp_file' => ['name' => 'Incorporation File', 'file' => $incorp_file],
                'policy_file' => ['name' => 'Policy File', 'file' => $policy_file],
                'statement_file' =>  ['name' => 'Annunal Statement', 'file' => $statement_file],
                'cert_file' =>  ['name' => 'ISO Certificate', 'file' => $cert_file],
                'need_file' => ['name' => 'Need Validation', 'file' => $need_file],
                'lexis_file' =>  ['name' => 'Lexis File', 'file' => $lexis_file],
                'screenshot_file' =>  ['name' => 'Screenshots', 'file' => $screenshot_file],
                'renew_lexis_file' =>  ['name' => 'Renewal Lexis File', 'file' => $renew_lexis_file],
                'renew_screenshot_file' =>  ['name' => 'Renewal Screenshots', 'file' => $renew_screenshot_file],

            ];

            return response()->json($files, 200);
        }
        return response()->json(['message' => 'Something Went wrong'], 500);
    }

    public function uploadFile(Request $request)
    {
        $this->validate($request,['name'=>'required','file'=>'mimes:jpeg,JPG,PNG,bmp,png,pdf']);
        $e = Partner::where('uuid', $request->id)->with('ethics')->with('arrangements')->with('type')->first();

        if ($e) {

            if ($request->name == 'incorp_file') {
                $name = $request->name;
                $file = $request->hasFile('file');
                if ($file) {
                    $extension = $request->file('file')->extension();
                    $upload_file = $e->uuid . '/updated/' . md5(date('Y-m-d H:i:s')) . '.' . $extension;
                    Storage::disk('myDisk')->put($upload_file, File::get($request->file('file')));
                    $e->$name = $upload_file;
                    $e->save();
                }
            } else {
                $name = $request->name;
                $file = $request->hasFile('file');
                if ($file) {
                    $extension = $request->file('file')->extension();
                    $upload_file = $e->uuid . '/updated/' . md5(date('Y-m-d H:i:s')) . '.' . $extension;
                    Storage::disk('myDisk')->put($upload_file, File::get($request->file('file')));
                    $e->ethics->$name = $upload_file;
                    $e->ethics->save();
                }
            }

            return response()->json(['message' => 'File Uploaded Successfully'], 200);
        }
    }
}
