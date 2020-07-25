<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Admin\Application;


class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        $user=Auth::user();
       
        $apps=Application::getApplicationAccess();

        
        return view('home')->with('apps',$apps);
    }
}
