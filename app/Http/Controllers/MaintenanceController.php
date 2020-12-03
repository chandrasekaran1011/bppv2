<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Artisan;

class MaintenanceController extends Controller
{
    public function maintenance(Request $request){
        
                 
        $r= Artisan::call('down');
       
        return redirect()->route('login');
    }

    public function queueRetry(){
        $r= Artisan::call('queue:retry');
       
        return redirect()->route('login');
    }
}
