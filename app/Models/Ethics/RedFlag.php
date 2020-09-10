<?php

namespace App\Models\Ethics;

use Illuminate\Database\Eloquent\Model;
use Cache;

class RedFlag extends Model
{
    protected $fillable=['flag'];

    public static function allFlagsArray(){
        $flags=Cache::remember('allFlags', 86400, function () {
            $flgs= RedFlag::all();
            $data=[];
            foreach($flgs as $f){
                array_push($data,$f->flag);
            }
            return $data;

        });
        
        return $flags;
    }
}
