<?php

namespace App\Http\Controllers\Ethics;

use App\Http\Controllers\Controller;
use App\Models\Ethics\Ethics;
use App\Models\Ethics\Partner;
use App\Models\Ethics\Renew;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class RenewalController extends Controller
{
    public function renew(Request $request){
              
        $user=Auth::user();
              
        $e=Partner::where('uuid',$request->unique)->with('ethics')->whereIn('status',[4,6])->first();
        if($e){
            $exception = DB::transaction(function () use ($request, $user, $e) {
                $e->renew_assign=$request->ims_assign;
                $e->status=10;
                $e->is_renew=1;
                $e->can_renew=0;
                $e->renew_initiated=Carbon::now();
                $check=$e->save();

                $r=$e->renews()->latest()->first();
                $r->pcountry=$e->ethics->pcountry;
                $r->pcpi=$e->ethics->pcpi;
                $r->phase=$e->ethics->phase;
                $r->scope=$e->ethics->scope;
                $r->contract=$e->ethics->contract;
                $r->cdo=$e->ethics->cdo;
                $r->cdo_date=$e->ethics->cdo_date;
                $r->mutual=$e->ethics->mutual;
                $r->recomm=$e->ethics->recomm;
                $r->mitigation=$e->ethics->mitigation;
                $r->screenshot_file=$e->ethics->screenshot_file;
                $r->decision=$e->ethics->ims_decision;
                $r->integrity=$e->ethics->integrity;
                $r->search=$e->ethics->search;
                $r->flag=$e->ethics->flag;

                $r->ims_by=$e->ethics->ims_by;
                $r->ims_on=$e->ethics->ims_at;
                $r->pm_by=$e->ethics->pm_by;
                $r->pm_on=$e->ethics->pm_at;
                $r->save();
                
                $e->ethics->renew_contract = $request->contract;
                $e->ethics->renew_phase = $request->phase;
                $e->ethics->renew_scope = $request->scope;
                $e->ethics->renew_cdo = $request->cdo;
                if ($request->dcdo) {
                    $e->ethics->renew_cdo_date = $request->dcdo;
                }
                $e->ethics->renew_mutual = $request->mutual;
                $e->ethics->renew_recomm = $request->recomm;
                $e->ethics->renew_pcountry = $request->pcountry;
                $e->ethics->renew_pcpi = $request->pcpi;
                $e->ethics->renew_pm_by = $user->id;
                $e->ethics->renew_pm_at = Carbon::now();
                $e->ethics->renew_search=$request->search;
                $e->ethics->renew_breach=$request->satis;

                $e->ethics->renew_flag = $request->flag;
                $e->ethics->renew_mitigation = $request->mitigations;

                $file = $request->hasFile('screenshot_file');
                if ($file) {
                    $extension = $request->file('screenshot_file')->extension();
                    $search_file = $e->uuid .'/search/' . md5(date('Y-m-d H:i:s')) . '.' . $extension;
                    Storage::disk('myDisk')->put($search_file, File::get($request->file('screenshot_file')));
                    $e->ethics->renew_screenshot_file = $search_file;
                }

                $e->ethics->save();
                    
                    $r=new Renew();
                    $r->partner_id=$e->id;
                    $r->integrity=0;
                    $r->search=$request->search;
                    $r->breach=$request->satis;
                    $r->flag=$request->flag;
                    $r->mitigation=$request->mitigations; 

                    $r->user_id=Auth::id();

                    $file = $request->hasFile('screenshot_file');
                    if ($file) {
                        $r->screenshot_file = $search_file;
                    }

                    $r->pcountry=$e->ethics->pcountry;
                    $r->pcpi=$request->pcpi;
                    $r->phase=$request->phase;
                    $r->scope=$request->scope;
                    $r->contract=$request->contract;
                    $r->cdo=$request->cdo;
                    $r->cdo_date=$request->dcdo;
                    $r->mutual=$request->mutual;
                    $r->recomm=$request->recomm;
                    $r->pm_by = $user->id;
                    $r->pm_on = Carbon::now();

                    $r->initial=0;
                    $r->save();
            });
            $check = is_null($exception) ? true : false;

            if ($check) {
                
                return response()->json(['success'=>true,'message'=>'Renewal Initiated'],200);
            }
            else{
                return response()->json(['message'=>'Renewal Process Error'],500);
            }
        }
        else{
            return response()->json(['message'=>'Renewal Process Error.(E2)'],500);
        }
    }

    public function renewApprove(Request $request){

        $user=Auth::user();
              
            $e=Partner::where('uuid',$request->unique)->with('ethics')->whereIn('status',[10])->first();
            if($e){
                $exception = DB::transaction(function () use ($request, $user, $e) {
                    if($request->decision==1 || $request->decision==2 ){
                        $e->status=4;
                        $e->approved_on=Carbon::now();
                        $e->due_on=Carbon::now()->addMonths(24);
                        $e->approved_by=Auth::id();
                    }
                    else{
                        $e->status=5;
                        $e->approved_on=Carbon::now(); 
                        $e->approved_by=Auth::id();        
                    }

                    $e->save();

                    $p=Ethics::where('partner_id',$e->id)->where('active',1)->first();


                    $p->renew_integrity=$request->integrity;
                    $p->decision=$request->decision;
                    $p->reason=$request->reason;
                    $p->add=$request->add;

                    $p->renew_ims_decision=$request->decision;
                    $p->renew_ims_reason=$request->reason;
                    $p->renew_ims_add=$request->add;
                    $p->renew_flag_action=$request->flag_action;

                    
                    $file = $request->hasFile('lexis_file');
                    if ($file) {
                        $extension = $request->file('lexis_file')->extension();
                        $lexis_file = $e->uuid . '/lexis/' . md5(date('Y-m-d H:i')) . '.' . $extension;
                        Storage::disk('myDisk')->put($lexis_file, File::get($request->file('lexis_file')));
                        $p->renew_lexis_file = $lexis_file;
                    }

                    if($request->condition){
                        $p->condition=$request->condition;
                        $p->renew_ims_condition=$request->condition;
                    }

                    $p->renew_ims_by=Auth::id();
                    $p->renew_ims_at=Carbon::now();
                    $p->save();

                    
                        
                    $r=$e->renews()->latest()->first();
                    
                    $r->decision=$request->decision; 
                    if($request->condition){
                        $r->condition=$request->condition;
                    }
                    $r->reason=$request->reason;
                    $r->add=$request->add;
                    $r->ims_by=Auth::id();
                    $r->ims_on=Carbon::now();
                    $r->save();

                        
                    
                });

                $check = is_null($exception) ? true : false;
                if ($check) {
                    return response()->json(['message'=>'Renewal Completed'],200);
                }
                else{
                    return response()->json(['message'=>'Renewal Process Error'],500);
                }

            }
            else{
                
                return response()->json(['message'=>'Error in Renewing'],500);
            }
        }
    
}
