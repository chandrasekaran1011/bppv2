<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

use App\Models\Rms\RiskRegister;
use Auth;

class BusinessUnit extends Model
{
    public static function getActiveArray(){
        $apps=BusinessUnit::all();
        
        $data=[];
        $x=1;
        foreach($apps as $c){

            $data[]=[
                'id'=>$c->id,
                'name'=>$c->name,
            ];
            $x++;
        }
        return $data;
    }

    public static function getRmsBu(){
        $bu=BusinessUnit::select('id','name')->get();
        $user=Auth::user();
        if(!Auth::user()->isAdmin()){
            $log=[];
            foreach($bu as $b){
                if(in_array($b->id,$user->getBuIDs())){
                    $log[]=[
                        'id'=>$b->id,
                        'name'=>$b->name
                    ];
                }

            }
            return $log;
            
        }
        else{
            return $bu;
        }   
    }

    

    public function registers(){

        return $this->hasMany('App\Models\Rms\RiskRegister', 'business_unit', 'id')->where('status',1);
        
    }   
    

}
