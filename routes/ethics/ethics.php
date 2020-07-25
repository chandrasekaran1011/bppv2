<?php

Route::get('/ethics', 'EthicsController@index')->name('index');

Route::post('/getFormData', 'EthicsController@getFormData')->name('getFormData');

Route::post('storePublicForm','EthicsController@storePublicForm')->name('storePublicForm');

Route::post('storeOtherForm','EthicsController@storeOtherForm')->name('storeOtherForm');

Route::post('detail','EthicsController@detail')->name('detail');