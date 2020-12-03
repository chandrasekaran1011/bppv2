<?php

namespace App\Models\Admin;
use App\Models\Admin\Country;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Auth;
use Spatie\Permission\Models\Permission;

class Project extends Model
{
    use SoftDeletes;

   
    protected $dates = ['deleted_at'];
    protected $fillable=['name'];
    

    public function country()
    {
        return $this->belongsTo('App\Models\Admin\Country', 'country_id', 'id');
    }

    public static function getArray(){
        $projects=Project::withTrashed()->get();
        
        $data=[];
        $x=1;
        foreach($projects as $c){
            $active=true;
            if($c->deleted_at){
                $active=false;
            }
            $data[]=[
                'sno'=>$x,
                'id'=>encrypt($c->id),
                'name'=>$c->name,
                'code'=>$c->code,
                'country'=>$c->country->name,
                'cid'=>$c->country->id,
                'active'=>$active,
                'unique'=>$c->id
            ];
            $x++;
        }

        return $data;
    }

    public static function getActiveArray(){
        $projects=Project::with('country')->get();
        
        $data=[];
        $x=1;
        foreach($projects as $c){
            $active=true;
            if($c->deleted_at){
                $active=false;
            }
            $data[]=[
                'sno'=>$x,
                'id'=>encrypt($c->id),
                'name'=>$c->name,
                'code'=>$c->code,
                'country'=>$c->country->name,
                'cid'=>$c->country->id,
                'active'=>$active,
                'unique'=>$c->id
            ];
            $x++;
        }

        return $data;
    }

    public static function getDataArray(){
        $projects=Project::get(['name','id']);

        $user=Auth::user();
        if(!Auth::user()->isAdmin()){
            $log=[];
            foreach($projects as $b){
                if(in_array($b->id,$user->getProjectsIDs())){
                    $log[]=[
                        'unique'=>$b->id,
                        'name'=>$b->name
                    ];
                }

            }
            return $log;
            
        }
        else{
            $log=[];
            foreach($projects as $b){
                $log[]=[
                    'unique'=>$b->id,
                    'name'=>$b->name
                ];
              
            }
            return $log;
        }   

    }

   
}
