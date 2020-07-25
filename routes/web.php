<?php

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

Auth::routes(['register' => false]);

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/getfile/', 'Admin\HelperController@file')->name('file')->middleware('auth');

Route::group(['namespace' => 'Admin', 'as' => 'admin.','middleware'=>['auth','can:view Backend']], function () {
    include(__DIR__.'/admin/admin.php');
});

Route::group(['namespace' => 'Ethics', 'as' => 'ethics.','middleware'=>['auth']], function () {
    include(__DIR__.'/ethics/ethics.php');
});

Route::get('ethics/partnerQuestionForm/{id}', 'Ethics\EthicsController@PartnerQuestion')->name('partnerQuestionForm');
Route::post('partnerform/store/{id}','Ethics\EthicsController@partnerstore')->name('partnerStore');
Route::post('individualform/store/{id}','Ethics\EthicsController@individualPartnerstore')->name('individualStore');

