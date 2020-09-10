<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Cache;

class Country extends Model
{
    public static function getArray(){

        $country=Cache::remember('allCountries', 860000, function () {
            return Country::select(['id','name'])->get();
        });
        

        $data=[];
        foreach($country as $c){
            $data[]=[
                'id'=>$c->id,
                'name'=>$c->name
            ];
        }

        return $data;
    }

    public static function getDataArray(){

        $countries=Cache::remember('allCountries', 860000, function () {
            return Country::all();
        });
        
        $data=[];
        $x=1;
        foreach($countries as $c){

            $data[]=[
                'name'=>$c->name,
                'unique'=>$c->id,
                'cpi'=>$c->cpi
            ];
            $x++;
        }

        return $data;
    }
}
