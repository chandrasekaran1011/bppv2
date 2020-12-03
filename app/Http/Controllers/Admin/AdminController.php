<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Project;
use App\Models\Admin\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    public function index(){
        return view('admin.index');
    }

    public function dashboard(){
        $users=User::where('active',1)->count();
        $roles=Role::count();
        $entity=Project::count();
      
        return response()->json([
            'users'=>$users,
            'roles'=>$roles,
            'entity'=>$entity
        ], 200);
    }
}
