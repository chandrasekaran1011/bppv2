<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Auth;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\Models\Admin\User;

class UserController extends Controller
{
    public function create(Request $request){
        $this->validate($request,['name'=>'required','email'=>'required|email:rfc|unique:App\Models\Admin\User','assignedRole'=>'required']);

        $user=User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt('password@1011')
        ]);

        $user->syncRoles($request->assignedRole);

        $user->syncPermissions($request->permissions);
        
        $user->projects()->sync($request->projects);

        return response()->json(['User Created Successfully'], 200);
    }

    public function getUser(Request $request ){
        $user=User::all();

        $data=[];


        foreach($user as $u){
            $actPerm=true;
            if(Auth::id()==$u->id){
                $actPerm=false;
            }
            $data[]=[
                'name'=>$u->name,
                'email'=>$u->email,
                'uniqueId'=>$u->uuid,
                'active'=>$u->active,
                'permission'=>$u->getPermissionNames(),
                'roles'=>$u->getRoleNames(),
                'actPerm'=>$actPerm,
                'projects'=>$u->getProjectsIDs(),

            ];
        }

        return response()->json($data, 200);
    }

    public function action(Request $request){
        $user=User::where('uuid',$request->uniqueId)->first();
        $user->active=$request->action;
        $user->save();

        return response()->json('User status Updated', 200);
    }

    public function update(Request $request){
        $this->validate($request,['name'=>'required','email'=>'required|email:rfc|unique:users,email,'.$request->uniqueId.',uuid','assignedRole'=>'required','uniqueId'=>'required']);
       
        $user=User::where('uuid',$request->uniqueId)->first();
        $user->email=$request->email;
        $user->name=$request->name;
        
        $user->save();

        $user->syncRoles($request->assignedRole);

        $user->syncPermissions($request->permissions);

        $user->projects()->sync($request->projects);

        return response()->json(['User Updated Successfully'], 200);

    }
}
