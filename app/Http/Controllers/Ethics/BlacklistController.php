<?php

namespace App\Http\Controllers\Ethics;

use App\Events\Ethics\PartnerBlacklisted;
use App\Events\Ethics\PartnerEnlisted;
use App\Http\Controllers\Controller;
use App\Models\Ethics\Ethics;
use App\Models\Ethics\Partner;
use Illuminate\Http\Request;

use Auth;
use Carbon\Carbon;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Log;



class BlacklistController extends Controller
{
    
    public function blacklistPartner(Request $request){

        $user=Auth::user();
        
        $p=Partner::where('uuid',$request->unique)->where('status', 4)->first();

        if($p){
            $p->blacklist_by=Auth::user()->id;
            $p->blacklist_on=Carbon::now();
            $p->blacklist_reason=$request->reason;
            $p->blacklist_till=$request->date;
            $p->status=7;
            $check=$p->save();
    
            if($check){
                
                event(new PartnerBlacklisted($p));
                
                return response()->json(['message'=>'Business Partner Blacklisted'],200);
            }
            else{
                return response()->json(['message'=>'Error in Blacklisting'],500);
            }
        }
        else{
            return response()->json(['message'=>'Something went wrong'],500);
        }

       
    }


    public function whitelistPartner(Request $request){
        $user=Auth::user();

        $p=Partner::where('uuid',$request->unique)->where('status',7)->first();
        if($p){

            $exception = DB::transaction(function () use ($request, $user, $p) {

            $p->status=4;
            $p->approved_on=Carbon::now();
            $p->blacklist_remarks=$request->remarks;
        
            $p->due_on=Carbon::now()->addMonths(config('ethics.partner_validity',24));
            $p->approved_by=Auth::id();

            $check=$p->save();
            

            $e=Ethics::where('partner_id',$p->id)->where('active',1)->first();

            $file=$request->hasFile('screenshot_file');
            if($file){
                $extension = $request->file('screenshot_file')->extension();
                $search_file=$p->uuid.'/search/'.md5(date('Y-m-d H:i')).'.'.$extension ;
                Storage::disk('myDisk')->put($search_file,File::get($request->file('screenshot_file')));
                $e->screenshot_file=$search_file;
            }

            $file=$request->hasFile('lexis_file');
            if($file){
                $extension = $request->file('lexis_file')->extension();
                $lexis_file=$p->uuid.'/lexis/'.md5(date('Y-m-d H:i')).'.'.$extension ;
                Storage::disk('myDisk')->put($lexis_file,File::get($request->file('lexis_file')));
                $e->lexis_file=$lexis_file;
            }

            $e->save();

        });

            $check = is_null($exception) ? true : false;

            if($check){
                
                event(new PartnerEnlisted($p));
                return response()->json(['message'=>'Business Partner Enlisted'],200);
            }
            else{
                
                
                return response()->json(['message'=>'Error in Enlisting'],500);
            }
        }
        else{
            return response()->json(['message'=>'UnAuthorized or Fatal Error'],500);
        }
        


        
    }
}
