<?php

namespace App\Models\Ethics;

use Illuminate\Database\Eloquent\Model;

class Mitigation extends Model
{
    protected $fillable=['mitigation'];

    public static function allMitigationsArray(){
        $mitigations=Mitigation::all();
        $data=[];
        foreach($mitigations as $f){
            array_push($data,$f->mitigation);
        }

        return $data;
    }
}
