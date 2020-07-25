<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Project;


use App\Models\Admin\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function create(Request $request)
    {

        $this->validate($request, ['name' => 'required', 'permissions' => 'required']);

        try {
            $role = Role::create(['name' => $request->name]);
            $role->syncPermissions($request->permissions);
        } catch (Exception $e) {
            return response()->json(['Invalid Inputs'], 422);

        }
        return response()->json(['Roled Created'], 200);

    }

    public function update(Request $request)
    {

        $this->validate($request, ['name' => 'required', 'permissions' => 'required', 'oldName' => 'required']);

        try {
            $role = Role::where('name', $request->oldName)->first();
            $role->name = $request->name;
            $role->save();
            $role->syncPermissions($request->permissions);
        } catch (Exception $e) {
            return response()->json(['Invalid Inputs'], 422);

        }
        return response()->json(['Roled Created'], 200);

    }

    public function getRoles()
    {
        $roles = Role::all();
        $permission = Permission::all();

        $perm = [];
        foreach ($permission as $p) {
            $perm[] = [
                'name' => $p->name,
                'group' => $p->perm_group,
            ];
        }

        $groups = [];
        $gps = Permission::select('perm_group')->distinct()->get();
        $collection = collect($perm);
        foreach ($gps as $g) {

            $filtered = $collection->where('group', $g->perm_group)->all();
            $gperm = [];
            foreach ($filtered as $f) {
                array_push($gperm, $f['name']);
            }

            $groups[] = [
                'name' => $g->perm_group,
                'perms' => $gperm,
            ];
            //array_push($groups,$g->perm_group);

        }

        $log = [];
        $count = 1;
        foreach ($roles as $r) {
            $users = User::role($r->name)->count();
            $log[] = [
                'sno' => $count,
                'name' => $r->name,
                'permission' => $this->getRolePermissions($r),
                'parray' => $this->getRolePermissions($r, 0),
                'users' => $users,

            ];
            $count++;
        }

        $projects = Project::getActiveArray();

        return response()->json(['roles' => $log, 
        'permission' => $perm, 
        'groups' => $groups, 
        'projects' => $projects, ], 200);
    }

    public function getRolePermissions(Role $r, $format = 1)
    {
        $permission = $r->permissions()->select('name')->get();

        $arr = [];
        foreach ($permission as $p) {
            array_push($arr, $p->name);
        }
        if ($format == 1) {
            return ucfirst(implode(",", $arr));
        } else {
            return $arr;
        }

    }
}
