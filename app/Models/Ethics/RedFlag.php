<?php

namespace App\Models\Ethics;

use Illuminate\Database\Eloquent\Model;

class RedFlag extends Model
{
    protected $fillable=['flag'];

    public static function allFlagsArray(){
        $flags=RedFlag::all();
        $data=[];
        foreach($flags as $f){
            array_push($data,$f->flag);
        }

        return $data;
    }
}
