<?php

namespace App\Models\Ethics;

use Illuminate\Database\Eloquent\Model;
use App\Models\Ethics\Ethics;

// use Altek\Accountant\Contracts\Recordable;
// use Altek\Accountant\Recordable as RecordableTrait;
// use Altek\Eventually\Eventually;

use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\Uuid;

class Partner  extends Model implements Auditable
{
    use  \OwenIt\Auditing\Auditable,
    Uuid,
    SoftDeletes ;

    protected $dates=['blacklist_till','blacklist_on','doi','approved_on','due_on'];

    public function ethics()
    {
        return $this->hasOne('App\Models\Ethics\Ethics', 'partner_id', 'id');
        // return $this->hasMany('App\Models\Ethics\Ethics', 'partner_id', 'id')->where('active',1)->first();
    }

    public function renews()
    {
        return $this->hasMany('App\Models\Ethics\Renew', 'partner_id', 'id');
    }

    public function renewals()
    {
        return $this->hasMany('App\Models\Ethics\Renew', 'partner_id', 'id')->where('initial',0)->get();
    }

    public function ethicsall()
    {
        return $this->hasMany('App\Models\Ethics\Ethics', 'partner_id', 'id');
    }

    public function searches(){
        return $this->hasMany('App\Models\Ethics\Search', 'partner_id', 'id');
    }

    public function getaudits(){
        return $this->hasMany('App\Models\Ethics\Audit', 'partner_id', 'id')->orderBy('created_at','desc');
    }

    public function type()
    {
        return $this->belongsTo('App\Models\Ethics\PartnerType', 'type_id', 'id');
    }

    public function yn($id){
        if($id==1){
            return 'Yes';
        }
        else{
            return 'No';
        }
    }

    public function mutual($id){
        if($id==1){
            return 'Mutual Agreement';
        }
        else{
            return 'Competition';
        }
    }

    public function search($id){
        if($id==1){
            return 'Yes';
        }
        elseif($id==2){
            return 'n.a. (according to procedure cf.3.1)';
        }
        else{
            return 'No';
        }
    }

    public function policy($id){
        if($id==1){
            return 'Yes';
        }
        elseif($id==2){
            return 'No information found';
        }
        else{
            return 'No';
        }
    }


    public function project(){
        return $this->belongsTo('App\Models\Admin\Project')->withTrashed();
    }

    public function getStatus(){
        $stat='';
        if($this->status==1){$stat='Registration Initiated';}
        elseif($this->status==2){$stat='Partner Responded';}
        elseif($this->status==3){$stat='Compliance Approval pending';}
        elseif($this->status==4){$stat='Partner Approved';}
        elseif($this->status==5){$stat='Partner Rejected';}
        
        elseif($this->status==6){$stat='Partner Expired';}
        elseif($this->status==7){$stat='Partner Blacklisted';}

        elseif($this->status==8){$stat='Approval Pending with Group Head';}
        elseif($this->status==9){$stat='Approval Pending with Ethics Committee';}
                       
        return $stat;
    }

    public function country()
    {
        return $this->belongsTo('App\Models\Admin\Country', 'country_id', 'id');
    }
}
