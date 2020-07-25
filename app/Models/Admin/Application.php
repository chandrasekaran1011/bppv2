<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

use Auth;

class Application extends Model
{
    public static function getActiveArray(){
        $apps=Application::all();
        
        $data=[];
        $x=1;
        foreach($apps as $c){

            $data[]=[
                'sno'=>$x,
                'id'=>$c->id,
                'name'=>$c->name,
                'sname'=>$c->short,
                'image'=>$c->image,
                'link'=>$c->link,
            ];
            $x++;
        }

        return $data;
    }

    public static function getApplicationAccess(){
        $apps=Application::all();
        $user=Auth::user();
        $app=[];

        foreach($apps as $a){
            if($user->can('view',$a)){
                array_push($app,$a);
            }
        }
        return $app;
        
    } 
}
