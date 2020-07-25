<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Admin\Project;
use App\Models\Admin\Country;
use App\Models\Admin\User;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Log;


class ProjectController extends Controller
{
    public function index(){
         
        $projects=Project::getArray();
        $country = Country::getArray();
     
    
        
        $data=[
            'projects'=>$projects,
            'countries'=>$country
        ];

        return response()->json($data, 200);
        
    }

    public function store(Request $request)
    {
        $this->validate($request,['name'=>'required|unique:projects,name','code'=>'required|unique:projects,code','country'=>'required']);

        $project=new Project();
        $project->name=$request->name;
        $project->code=$request->code;
        $project->country_id=$request->country;
        $check=$project->save();
        if($check){
            return response()->json(['message'=>'Project Added Successfully']);
        }
        else{
            return response()->json(['message'=>'ErrorAdding']);
            
        }

        
    }

    public function update(Request $request){
  
    
        try {
            $id = decrypt($request->id);
        } 
        catch (DecryptException $e) {
            Log::critical('Project Key Tampered');
            return response()->json(['message'=>'Error Updating1']);
        }

        $this->validate($request,['name'=>'required|unique:projects,name,'.$id,'code'=>'required|unique:projects,code,'.$id,'country'=>'required']);
        
        $project=Project::where('id',$id)->first();
        $project->name=$request->name;
        $project->code=$request->code;
        $project->country_id=$request->country;
        $check=$project->save();
        if($check){
            return response()->json(['message'=>'Project Updated Successfully']);
        }
        else{
            return response()->json(['message'=>'Error Updating']);
            
        }    
    }

    public function delete(Request $request){
            
        try {
            $id =decrypt($request->id);
        } 
        catch (DecryptException $e) {
            Log::critical('Project Key Tampered');
            return response()->json(['message'=>'Error Updating']);
        }
        $project=Project::where('id',$id)->delete();
        if($project){
            return response()->json(['message'=>'Project Deleted Successfully']);
        }
        else{
            return response()->json(['message'=>'Error Updating']);
            
        }    
    }


}
