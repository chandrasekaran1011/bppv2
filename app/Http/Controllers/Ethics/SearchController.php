<?php

namespace App\Http\Controllers\Ethics;

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
        else{
            return abort(502);
        }
        if($entity==0){
            $partner=Partner::select(['uuid','created_at','name','status','reg'])->where("$field",'ILIKE','%'.$v.'%')->limit(5000)->get();
        }
        else{
            $partner=Partner::select(['uuid','created_at','name','status','reg'])->where('project_id',$entity)->where("$field",'ILIKE','%'.$v.'%')->limit(5000)->get();
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
}