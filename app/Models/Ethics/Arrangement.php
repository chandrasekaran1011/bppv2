<?php

namespace App\Models\Ethics;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Arrangement extends Model
{
    use SoftDeletes;

    protected $dates=['cdo_date'];
}
