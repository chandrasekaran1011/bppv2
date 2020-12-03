<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

    if(config('ethics.authentication')=="local"){
        Auth::routes(['register' => false]);
    }
    else{
        Route::get('/login',function(){
            return redirect('/login/azure');
        })->name('login');

        Route::get('/login/azure', '\App\Http\Middleware\AppAzure@azure');
        Route::get('/login/azurecallback', '\App\Http\Middleware\AppAzure@azurecallback');
        Route::get('/logout/azure', '\App\Http\Middleware\AppAzure@azurelogout');

        Route::get('/logout',function(){
            Auth::logout();
            return redirect('/login');
            //return redirect('/logout/azure');
        })->name('logout');

    }



Route::get('/home', 'HomeController@index')->name('home');

Route::get('/getfile/', 'Admin\HelperController@file')->name('file')->middleware('auth');

Route::group(['namespace' => 'Admin', 'as' => 'admin.','middleware'=>['auth','can:view Backend']], function () {
    include(__DIR__.'/admin/admin.php');
});

Route::group(['namespace' => 'Ethics', 'as' => 'ethics.','middleware'=>['auth']], function () {
    include(__DIR__.'/ethics/ethics.php');
});

Route::get('ethics/partnerQuestionForm/{id}', 'Ethics\EthicsController@PartnerQuestion')->name('partnerQuestionForm');
Route::post('partnerform/store/{id}','Ethics\EthicsController@partnerStore')->name('partnerStore');
Route::post('individualform/store/{id}','Ethics\EthicsController@individualPartnerStore')->name('individualStore');

Route::get('/maintenance', 'MaintenanceController@maintenance')->name('maintenance');

Route::get('/queueRetry', 'MaintenanceController@queueRetry')->name('queueRetry');

