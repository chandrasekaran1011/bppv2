<?php

namespace App\Http\Controllers\Ethics;

use App\Http\Controllers\Controller;
use App\Models\Ethics\Arrangement;
use App\Models\Ethics\Audit;
use App\Models\Ethics\Partner;
use Illuminate\Http\Request;
use Auth;

class ArrangementController extends Controller
{
    public function store(Request $request)
    {

        $id = $request->unique;
        $p = Partner::where('uuid', $id)->where('status', 4)->first();

        if ($p) {
            $a = new Arrangement();
            $a->partner_id = $p->id;
            $a->scope = $request->scope;
            $a->contract = $request->contract;
            $a->pcountry = $request->pcountry;
            $a->pcpi = $request->pcpi;
            $a->phase = $request->phase;

            $a->cdo = $request->cdo;
            $a->cdo_date = $request->dcdo;

            $a->mutual = $request->mutual;
            $a->recomm = $request->recomm;

            $a->remarks = $request->remarks;

            $a->user_id = Auth::id();
            $check = $a->save();

            if ($check) {
                
                $a=new Audit;
                $a->partner_id=$p->id;
                $a->user_id=Auth::id();
                $a->action="New Arrangement Added.(Project/Contract: ".$a->contract.' )';
                $a->save();


                return response()->json(['message' => 'New Arrangement Created']);
            } else {
                return response()->json(['message' => 'Something went wrong.'], 500);
            }
        }
        else{
            return response()->json(['message' => 'Something went wrong.'], 500);
        }
    }

    public function delete(Request $request)
    {
       $a= Arrangement::where('id',$request->id)->first();

       if($a){

            $audit=new Audit;
            $audit->partner_id=$a->partner_id;
            $audit->user_id=Auth::id();
            $audit->action="Arrangement Deleted(Project/Contract: ".$a->contract.' )';
            $audit->save();

            $a->delete();

            return response()->json(['message' => 'Arrangement Deleted']);
       }
       else{
            return response()->json(['message' => 'Something went wrong.'], 500);
       }

    }
}
