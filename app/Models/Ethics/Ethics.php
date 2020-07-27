<?php

namespace App\Models\Ethics;

use App\Models\Admin\Country;
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
    use  \OwenIt\Auditing\Auditable, SoftDeletes;

    protected $dates = ['pm_at', 'ims_at', 'cdo_date'];

    public function getphase()
    {
        if (!is_null($this->phase)) {
        $arr = ['Bid', 'Project', 'Others'];
        return $arr[$this->phase];
        }
        return null;
    }

    public function pm()
    {
        if (!is_null($this->pm_by)) {
            $user = User::find($this->pm_by);
            return $user->name;
        }
        return null;
    }

    public function complaince_by()
    {
        if (!is_null($this->ims_by)){
            $user = User::find($this->ims_by);
            return $user->name;
        }
        return null;

    }

    public function getdecision()
    {
        $val = $this->decision;
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

    public function getProjectCountry()
    {

        if (!is_null($this->pcountry)) {
            $val = $this->pcountry;

            $country = Country::where('id', $val)->select('name')->first();

            return $country->name;
        }
        return null;
    }
}
