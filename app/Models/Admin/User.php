<?php

namespace App\Models\Admin;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use Yadahan\AuthenticationLog\AuthenticationLogable;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Admin\Project;

use Auth;
use Spatie\Permission\Models\Permission;

class User extends Authenticatable
{
    use Notifiable,Uuid,AuthenticationLogable;
    use HasRoles;

    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $dates=['last_login_at'];


    public function isAdmin(){
        $user=Auth::user();
        if($user->hasRole('Super Admin')){
            return true;

        }
        else{
            return false;
        }
    }
    
    public function projects()
    {
        return $this->belongsToMany('App\Models\Admin\Project', 'user_has_projects', 'user_id', 'project_id');
    }


    public function getProjectsIDs(){
        $projects=$this->projects->all();
        $prj=[];
        foreach($projects as $p){
            array_push($prj,$p->id);
        }

        return $prj;
    }



    public function getAllPermissionsAttribute() {
        $permissions = [];
          foreach (Permission::all() as $permission) {
            if (Auth::user()->can($permission->name)) {
              $permissions[] = $permission->name;
            }
          }
          return $permissions;
      }

      public static function getApprover($permission){
        $imsUsers = User::permission($permission)->select(['id', 'name'])->get();  
        $userData = [];
        foreach ($imsUsers as $u) {
            $userData[] = [
                'unique' => $u->id,
                'name' => $u->name
            ];
        }
        return $userData;
      }
    

 
}

