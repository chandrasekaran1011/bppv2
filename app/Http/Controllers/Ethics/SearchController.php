<?php

namespace App\Http\Controllers\Ethics;

use App\Events\Ethics\GoogleSearchTrigger;
use App\Http\Controllers\Controller;
use App\Models\Ethics\Partner;
use Illuminate\Http\Request;
use Auth;


class SearchController extends Controller
{
    public function searchResult(Request $request){
        $criteria=$request->criteria;
        $v=strtolower($request->keyword);
        $entity=$request->entity;

        $user=Auth::user();

        if($criteria==1){
            $field='name';
        }elseif($criteria==2){
            $field='reg';
        }
        elseif($criteria==3){
            $field='cop_num';
        }
        elseif($criteria==4){
            $field='spot_code';
        }
        elseif($criteria==5){
            $field='bview';
        }
        else{
            return abort(502);
        }
        if($entity==0){
            $partner=Partner::where("$field",'ILIKE','%'.$v.'%')->limit(5000)->get();
        }
        else{
            $partner=Partner::where('project_id',$entity)->where("$field",'ILIKE','%'.$v.'%')->limit(5000)->get();
        }
        
        
        $log=[];
        $x=0;
        foreach($partner as $o){
            $id=encrypt($o->id);
            $detail=false;
            
           

            if($user->can('view',$o)){$detail=true;};
                                         
            $x++;     
                $log[]=[
                'sno'=>$x,
                'uuid'=>$o->uuid,
                'created_at'=>$o->created_at->toFormattedDateString(),
                'reg'=>$o->reg,
                'name'=>$o->name,
                'status'=>$o->getStatus(),
                'detail'=>$detail
                
            ];
            

            
        }
        
        return response()->json($log,200);
    }

    public function googleSearch(Request $request){

        $p = Partner::where('uuid', $request->id)->first();
        event(new GoogleSearchTrigger($p));
        return response()->json(['message'=>'Search Results will be Updated soon'], 200);

    }
}
