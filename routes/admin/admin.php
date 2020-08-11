<?php

use Illuminate\Support\Facades\Auth;

Route::get('/admin', 'AdminController@index')->name('home');

Route::get('/logout',function(){
    Auth::logout();
    //return redirect('/logout/azure');
 })->name('logout');

Route::post('createRole', 'RoleController@create')->name('createRole');
Route::post('updateRole', 'RoleController@update')->name('updateRole');
Route::post('getRoles', 'RoleController@getRoles')->name('getRoles');

Route::post('createUser', 'UserController@create')->name('createUser');
Route::post('getUser', 'UserController@getUser')->name('getUser');
Route::post('actionUser', 'UserController@action')->name('actionUser');
Route::post('updateUser', 'UserController@update')->name('updateUser');

Route::get('projectIndex', 'ProjectController@index')->name('projectIndex');
Route::post('storeProject', 'ProjectController@store')->name('storeProject');
Route::post('updateProject', 'ProjectController@update')->name('updateProject');
Route::post('deleteProject', 'ProjectController@delete')->name('deleteProject');

