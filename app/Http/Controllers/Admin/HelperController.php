<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class HelperController extends Controller
{
    public function file(Request $request){
        
        // dd($request->input('file'));

        $name='fileName';

        if($request->has('name')){
            $name=$request->input('name');
        }

        $ext =File::extension($request->input('file'));
        
              
        if($ext=='pdf'){
            $content_types='application/pdf';
           }elseif ($ext=='doc') {
             $content_types='application/msword';  
           }elseif ($ext=='docx') {
             $content_types='application/vnd.openxmlformats-officedocument.wordprocessingml.document';  
           }elseif ($ext=='xls') {
             $content_types='application/vnd.ms-excel';  
           }elseif ($ext=='xlsx') {
             $content_types='application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';  
           }elseif ($ext=='txt') {
             $content_types='application/octet-stream';  
           }
           else{
               return abort(502);
           }

           $headers = [
            'Content-Type'=>$content_types,
        ];

        ob_end_clean(); 
        
        return Storage::disk('rmsDisk')->download($request->input('file'),$name.'.'.$ext,$headers);
    }
}
