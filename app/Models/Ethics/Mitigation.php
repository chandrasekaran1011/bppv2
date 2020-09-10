<?php

namespace App\Models\Ethics;

use Illuminate\Database\Eloquent\Model;
use Cache;

class Mitigation extends Model
{
    protected $fillable=['mitigation'];

    public static function allMitigationsArray(){

        $miti=Cache::remember('allMitigations', 864000, function () {
            $mitigations=Mitigation::all();
            $data=[];
            foreach($mitigations as $f){
                array_push($data,$f->mitigation);
            }
    
            return $data;
        });
        
        return $miti;
    }
}
