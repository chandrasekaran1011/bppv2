<?php

namespace App\Http\Controllers\Ethics;

use App\Http\Controllers\Controller;
use App\Models\Ethics\Partner;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function partner(Request $request){
        if($request->input('key')=='$2b$10$xV/v1FrPp4KONlvHkP3rp.bPhZDN02V0gqBd21ZjX6HHxc1UO0HsW'){
            if($request->input('reg')){
                
                $e = Partner::where('reg', $request->input('reg'))->with('ethics')->with('arrangements')->with('type')->first();
                if($e){
                    $data=[
                        'reg' => $e->reg,
                        'name'=>$e->name,
                        'type'=>$e->getType(),
                        'address'=> $e->address,
                        'bview' => $e->bview,
                        'country' => $e->getCountry($e->country_id),
                        'cpi' => $e->cpi,
                        'validity' => is_null($e->due_on) ? '' : $e->due_on->toFormattedDateString(),
                        'status_name' => $e->getStatus(),
                        'status_id'=>$e->status,
                    ];
                    return response()->json(['data'=>$data], 200);  
                }
          
                return response()->json(['message'=>'Partner Not Found'], 500);
            }
            else{
                return response()->json(['message'=>'Provide Partner Registration Number'], 500);
            }


        }else{
            return response()->json(['message'=>'Invalid Key'], 500);
        }
    }
}
