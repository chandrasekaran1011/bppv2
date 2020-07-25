<?php

namespace App\Models\Ethics;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

// use Altek\Accountant\Contracts\Recordable;
// use Altek\Accountant\Recordable as RecordableTrait;
// use Altek\Eventually\Eventually;
use App\Models\Admin\User;

use OwenIt\Auditing\Contracts\Auditable;
use App\Models\Traits\Uuid;

class Ethics  extends Model implements Auditable
{
    use  \OwenIt\Auditing\Auditable, SoftDeletes  ;

    protected $dates=['pm_at','ims_at','cdo_date'];

    public function getphase(){
        $arr=['Bid','Project','Others'];
        return $arr[$this->phase];
    }

    public function pm(){
       $user= User::find($this->pm_by);
       return $user->name;
    }

    public function complaince_by(){
        $user= User::find($this->ims_by);
        return $user->name;
     }

     public function getdecision(){
        $val=$this->decision;

        if($val==1){
            return 'Approved';
        }
        elseif($val==2){
            return 'Approved with Condition';
        }
        else{
            return 'Declined';
        }
        
     }
}
