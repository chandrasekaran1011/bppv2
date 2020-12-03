<?php

namespace App\Models\Ethics;

use App\Models\Admin\Country;
use App\Models\Admin\User;
use Illuminate\Database\Eloquent\Model;
use App\Models\Ethics\Ethics;

// use Altek\Accountant\Contracts\Recordable;
// use Altek\Accountant\Recordable as RecordableTrait;
// use Altek\Eventually\Eventually;

use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\Uuid;

use Cache;

class Partner  extends Model implements Auditable
{
    use  \OwenIt\Auditing\Auditable,
    Uuid,
    SoftDeletes ;


    protected $dates=['blacklist_till','blacklist_on','doi','approved_on','due_on','question_submitted_on'];

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

    public function arrangements()
    {
        return $this->hasMany('App\Models\Ethics\Arrangement', 'partner_id', 'id');
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
        if($id==1 || $id==true){
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
        elseif($this->status==3){$stat='Local Compliance Officer Approval Pending';}
        elseif($this->status==4){$stat='Partner Approved';}
        elseif($this->status==5){$stat='Partner Rejected';}
        
        elseif($this->status==6){$stat='Partner Expired';}
        elseif($this->status==7){$stat='Partner Debarred';}

        elseif($this->status==8){$stat='Group Compliance Officer Approval Pending';}
        elseif($this->status==9){$stat='Ethics Committee Approval Pending';}
        elseif($this->status==10){$stat='Partner Renewal Pending';}
        elseif($this->status==11){$stat='Awaiting Entity Head Pursuance';}
                       
        return $stat;
    }

    public function country()
    {
        return $this->belongsTo('App\Models\Admin\Country', 'country_id', 'id');
    }

    public function getUsername($id){
        $u=Cache::remember('getUsers', 3600, function () {
            return User::all();   
        });
        
        $u=$u->where('id',$id)->first();
        if($u){
            return $u->name;
        }else{
            return null;
        }
    }

    public function getTime($time){
        if(is_null($time)){
            return '';
        }else{
            return $time->toFormattedDateString();
        }

    }

    public function getCountry($id,$field="name"){
        //Cache::forget('getCountry');
        if(is_null($id)){
            
        }else{
            $country=Cache::remember('getCountry', 86400, function () {
                return Country::select('id','name','cpi')->get();
            });

            $c=$country->where('id',$id)->first();

            if($c){
                return $c->$field;
            }
            
            return null; 
        }

    }

    public function getDecision($val)
    {
        
        if (!is_null($val)) {

            if ($val == 1) {
                return 'Approved';
            } elseif ($val == 2) {
                return 'Approved with Condition';
            } else {
                return 'Declined';
            }
        }

        return null;
    }

    public function getPhase($id=0)
    {
        $arr = ['Bid', 'Project', 'Miscellaneous'];
        if($id==0){
            if (!is_null($this->phase)) {
                return $arr[(int)($this->phase)-1];
            }
        }else{
            if (!is_null($id)) {
                return $arr[(int)($id)-1];
            }
        }

        return null;
    }

    public function questionnaireSubmitted(){
        if($this->status>1 ){
            if($this->q_submission){
                return true;
            }
            else{
                return false;
            }
        }else{
            return false;
        }
    }

    public function getArrangements(){
        $arrangements=$this->arrangements;
        $data=[];
        if($this->arrangements->count()>0){
            foreach($arrangements as $a){
                $data[]=[
                    'scope'=>$a->scope,
                    'remarks'=>$a->remarks,
                    'contract'=>$a->contract,
                    'pcountry'=>$this->getCountry($a->pcountry),
                    'pcpi'=>$a->pcpi,
                    'phase'=>$this->getPhase($a->phase),
                    'cdo'=>$this->yn($a->cdo),
                    'cdo_date'=>$this->getTime($a->cdo_date),
                    'mutual'=>$this->mutual($a->mutual),
                    'recomm'=>$this->yn($a->recomm),
                    'created_by'=>$this->getUsername($a->user_id),
                    'created_on'=>$this->getTime($a->created_at),
                    'unique'=>$a->id,
                ];
            }
        }


        return $data;
    }

    public function getType(){
        
            $type_id=$this->type_id;
            
            if($type_id!=8){
                return $this->type->name;
            }
            else{
                $pos='';
                if(!is_null($this->position)){
                    if($this->position<8){
                        $pos=PartnerType::where('id',$this->position)->first()->name;
                    }
                    else{
                        $pos='Freelancer';
                    }
                    
                }
                return 'Individual ('.$pos.')';
            }
        

    }

    


}
