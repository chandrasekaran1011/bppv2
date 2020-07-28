<?php

Route::get('/ethics', 'EthicsController@index')->name('index');

Route::post('/getFormData', 'EthicsController@getFormData')->name('getFormData');

Route::post('storePublicForm','EthicsController@storePublicForm')->name('storePublicForm');

Route::post('storeOtherForm','EthicsController@storeOtherForm')->name('storeOtherForm');

Route::post('storePmForm','EthicsController@storePmForm')->name('storePmForm');
Route::post('compForm','EthicsController@compForm')->name('compForm');

Route::post('view','EthicsController@view')->name('view');

Route::post('detail','EthicsController@detail')->name('detail');

Route::post('escalationForm','EthicsController@escalationForm')->name('escalationForm');

Route::post('searchResults','EthicsController@searchResults')->name('searchResults');

Route::post('auditResults','EthicsController@auditResults')->name('auditResults');

Route::get('/getfile/', 'EthicsController@file')->name('file');

Route::post('/resendNotification/', 'EthicsController@resendNotification')->name('resendNotification');

