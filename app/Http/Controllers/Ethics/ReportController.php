<?php

namespace App\Http\Controllers\Ethics;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PDF;
use App;
use App\Exports\Ethics\MasterReportExport;
use App\Exports\Ethics\MonthlyReportExport;
use App\Jobs\Ethics\createPDF;
use App\Models\Admin\Project;
use App\Models\Ethics\Partner;
use Carbon\Carbon;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class ReportController extends Controller
{
    public function index(Request $request,$id,$form){
        
        $logo_url=asset('images/systra.jpg');

        //$id=$request->input('id');
        //$form=$request->input('form');

        $e = Partner::where('uuid',$id)->with('ethics')->first();
        
        if($form==1){

            $name='questionnaire.pdf';
            if($e->type_id!=8){
                $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadView('ethics.pdf.questionnaire',[
                    'logo'=>$logo_url,
                    'e'=>$e
                ]);
            }
            else{
                $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadView('ethics.pdf.questionnaire-individual',[
                    'logo'=>$logo_url,
                    'e'=>$e
                ]);
            }

            Log::info('ques generated');

        }
        elseif($form==2){
            $name='BP Form.pdf';
            $pdf = PDF::loadView('ethics.pdf.partnerForm',[
                'logo'=>$logo_url,
                'e'=>$e
            ]);
        }
        //$time=(microtime(true)-LARAVEL_START);
        return $pdf->stream();
        
        if(isset($pdf)){
            return $pdf->download($name);
        }
        abort(404);
        
    }

    public function monthlyReport(Request $request){
        $this->validate($request,['keyword'=>'required','criteria'=>'required']);
        $criteria=$request->criteria;
        $v=$request->keyword;

        if($criteria==1){
            $field='created_at';
        }elseif($criteria==2){
            $field='approved_on';
        }

        $entity=$request->entity;
        $date = Carbon::createFromFormat('Y-m', $request->keyword)->month;
        $date1= Carbon::createFromFormat('Y-m', $request->keyword)->year;
        
        try {
            $check=$entity!=0?true:false;

                if($check){
                    $partner = Partner::whereMonth($field, $date)->whereYear($field, $date1)->where('project_id', $entity)->where('status',4)->get();
                }else{
                    $entity = Project::getDataArray();
                    $id= Arr::pluck($entity, 'unique');
                    $partner = Partner::whereMonth($field, $date)->whereYear($field, $date1)->whereIn('project_id', $id)->where('status',4)->get();
                }
              
            
        } catch (DecryptException $e) {
            abort('404', "No enter");
        }
 
        
        if($partner->count()>0){
            $data = $partner->map(function ($p, $key) {
                return [
                    'contract'=>$p->ethics->contract,
                    'name'=>$p->name,
                    'evaluation'=>'yes',
                    'control'=>"Red Flags : \n".$p->ethics->flag."\n \n Mitigation Action : \n".$p->ethics->mitigation,
                    'decision'=>$p->ethics->decisionVal($p->ethics->decision)."\n \n".$p->ethics->flag_action,

                ];
            });
            
            
            ob_end_clean(); 
            ob_start();
    
    
    
            $filename='temp/'.md5(date('Y-m-d H:i:s')).'.xlsx';
            $month=Carbon::createFromFormat('Y-m', $request->keyword);
            $val=Excel::store(new MonthlyReportExport($data->toArray(),$month->isoFormat('MMM YY')), $filename, 'myDisk');
    
            if($val){
    
                $data=[
                    'name'=>'Monthly Report',
                    'file'=>route('ethics.file',['file'=>$filename,'name'=>'Monthly Report','disk'=>'myDisk']),
                ];
                return response()->json($data);
            }
        }
        else{


            return response()->json(['message'=>'No Data Found'],204);
        }
    }

    
    public function masterReport(Request $request){
        $this->validate($request,['keyword'=>'required','criteria'=>'required']);
        $criteria=$request->criteria;
        $v=$request->keyword;

        if($criteria==1){
            $field='created_at';
        }

        $entity=$request->entity;
        $date = Carbon::createFromFormat('Y-m', $request->keyword)->month;
        $date1= Carbon::createFromFormat('Y-m', $request->keyword)->year;
        
        try {
            $check=$entity!=0?true:false;

                if($check){
                    $partner = Partner::whereMonth($field, $date)->whereYear($field, $date1)->where('project_id', $entity)->with('project')->with('type')->with('ethics')->get();
                }else{
                    $entity = Project::getDataArray();
                    $id= Arr::pluck($entity, 'unique');
                    $partner = Partner::whereMonth($field, $date)->whereYear($field, $date1)->whereIn('project_id', $id)->with('project')->with('type')->with('ethics')->get();
                }
              
            
        } catch (DecryptException $e) {
            abort('404', "No enter");
        }
 
        
        if($partner->count()>0){
            $data = $partner->map(function ($p, $key) {

                

                return [
                    'sno'=>$key+1,
                    'entity'=>$p->project->name,
                    'date'=>$p->getTime($p->created_at),  
                    'Business partner name'=>$p->name,                
                    'contract'=>$p->ethics->contract,
                    'type' => $p->getType(),
                    'org_type'=>$p->org_type,
                    'q_submitted'=>$p->yn($p->questionnaireSubmitted()),
                    'q_date'=>$p->getTime($p->question_submitted_on),
                    'form_submit'=>$p->yn(($p->status>2)),
                    'form_date'=>$p->getTime($p->ethics->pm_at),
                    'flag'=>$p->ethics->flag,
                    'mitigation'=>$p->ethics->mitigation,
                    'internet'=>$p->yn(($p->ethics->screenshot_file!=null)),
                    'lexis'=>$p->yn(($p->ethics->lexis_file!=null)),
                    'flag_action'=>$p->ethics->flag_action,
                    'decision'=>$p->ethics->decisionVal($p->ethics->decision),
                    'reason' => $p->ethics->reason,
                    'condition' => $p->ethics->condition,
                    'rdate'=>$p->getTime($p->approved_on),
                    'reg'=>$p->reg                   
                    
                ];
            });
            
            
            ob_end_clean(); 
            ob_start();
    
            
    
            $filename='temp/'.md5(date('Y-m-d H:i:s')).'.xlsx';
            $month=Carbon::createFromFormat('Y-m', $request->keyword);
            $val=Excel::store(new MasterReportExport($data->toArray(),$month->isoFormat('MMM YY'),$partner->count()), $filename, 'myDisk');
    
            if($val){
    
                $data=[
                    'name'=>'Master Report',
                    'file'=>route('ethics.file',['file'=>$filename,'name'=>'Master Report','disk'=>'myDisk']),
                ];
                return response()->json($data);
            }
        }
        else{


            return response()->json(['message'=>'No Data Found'],204);
        }
    }

    public function dashboard(Request $request){
        $entity=$request->entity;
        try {
            $check=$entity!=0?true:false;
                
                if($check){
                    $partner = Partner::where('project_id', $entity)->join('ethics','partners.id','=','ethics.partner_id')->join('partner_types','partners.type_id','=','partner_types.id')->selectRaw('partner_types.name,sum(case when ethics.decision=1 then 1 else 0 end) as approved,sum(case when ethics.decision=2 then 1 else 0 end) as approvedWithCond,sum(case when ethics.decision=0 then 1 else 0 end) as declined,count(partners.id) as total')->whereIn('status',[4,5])->groupBy('partner_types.name')->get();
                    $blacklisted=Partner::where('project_id', $entity)->where('status',7)->select('id')->get()->count();
                    $renewal=Partner::where('project_id', $entity)->where('status',6)->where('can_renew',1)->select('id')->get()->count();
                    $pending=Partner::where('project_id', $entity)->whereNotIn('status',[4,5,6,7])->select('id')->get()->count();
                    $total=Partner::where('project_id', $entity)->where('status',4)->select('id')->get()->count();

                }else{
                    $entity = Project::getDataArray();
                    $id= Arr::pluck($entity, 'unique');

                    $partner = Partner::whereIn('project_id', $id)->join('ethics','partners.id','=','ethics.partner_id')->join('partner_types','partners.type_id','=','partner_types.id')->selectRaw('partner_types.name,sum(case when ethics.decision=1 then 1 else 0 end) as approved,sum(case when ethics.decision=2 then 1 else 0 end) as approvedWithCond,sum(case when ethics.decision=0 then 1 else 0 end) as declined,count(partners.id) as total')->whereIn('status',[4,5])->groupBy('partner_types.name')->get();
                    $blacklisted =Partner::whereIn('project_id', $id)->where('status',7)->select('id')->get()->count();
                    $renewal=Partner::whereIn('project_id', $id)->where('status',6)->where('can_renew',1)->select('id')->get()->count();
                    $pending=Partner::whereIn('project_id', $id)->whereNotIn('status',[4,5,6,7])->select('id')->get()->count();
                    $total=Partner::whereIn('project_id', $id)->where('status',4)->select('id')->get()->count();
                }
          
        } catch (DecryptException $e) {
            return response()->json(['message'=>'Data Error'], 500);
        }

        
        return response()->json(
            [
                'statusReport'=>$partner,
                'blacklisted'=>$blacklisted,
                'renewal_pending'=>$renewal,
                'pending'=>$pending,
                'total'=>$total

            ]     
            , 200);

    }

    public function genrateReport(Request $request){
        $e=Partner::where('uuid',$request->id)->first();
        if($e)
        {
            createPDF::dispatch($e->id);
            return response()->json(['message'=>'Report Regeneration Initiated'], 200);
        }
        else{
            return response()->json(['message'=>'Error in processing'], 500);
        }
    }

}
