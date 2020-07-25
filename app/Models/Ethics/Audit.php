<?php

namespace App\Ethics;

use Illuminate\Database\Eloquent\Model;

class Audit extends Model
{
    protected $table = 'ethics_audit';
    public function user()
    {
        return $this->belongsTo('App\Models\Admin\User', 'user_id', 'id');
    }

    public function partner(){
        return $this->belongsTo('App\Models\Ethics\Partner','partner_id','id');
    }
}
