<?php

Route::get('/ethics', 'EthicsController@index')->name('index');

Route::post('/getFormData', 'EthicsController@getFormData')->name('getFormData');

Route::post('storePublicForm','EthicsController@storePublicForm')->name('storePublicForm');

Route::post('storeOtherForm','EthicsController@storeOtherForm')->name('storeOtherForm');

Route::post('storePmForm','EthicsController@storePmForm')->name('storePmForm');
Route::post('compForm','EthicsController@compForm')->name('compForm');

Route::post('view','EthicsController@view')->name('view');

Route::post('pendingApproval','EthicsController@pendingApproval')->name('pendingApproval');

Route::post('detail','EthicsController@detail')->name('detail');

Route::post('escalationForm','EthicsController@escalationForm')->name('escalationForm');

Route::post('searchResults','EthicsController@searchResults')->name('searchResults');

Route::post('auditResults','EthicsController@auditResults')->name('auditResults');

Route::get('/getfile/', 'EthicsController@file')->name('file');

Route::post('/resendNotification/', 'EthicsController@resendNotification')->name('resendNotification');

Route::post('entityData','EthicsController@entityData')->name('entityData');

Route::post('searchResult','SearchController@searchResult')->name('searchResult');

Route::post('questionnaireNotSubmitted','EthicsController@questionnaireNotSubmitted')->name('questionnaireNotSubmitted');

Route::post('deletePartner','EthicsController@deletePartner')->name('deletePartner');

//BlackListing and WhiteListing
Route::post('blacklistPartner','BlacklistController@blacklistPartner')->name('blacklistPartner');
Route::post('whitelistPartner','BlacklistController@whitelistPartner')->name('whitelistPartner');

//Utilities

Route::post('googleSearch','SearchController@googleSearch')->name('googleSearch');
Route::post('financeReview','EthicsController@financeReview')->name('financeReview');


//Renewals
Route::post('renew','RenewalController@renew')->name('renew');

Route::post('renewApprove','RenewalController@renewApprove')->name('renewApprove');

//Reports

Route::get('pdfDownload/{id}/{form?}','ReportController@index')->name('pdfDownload');

Route::post('monthlyReport','ReportController@monthlyReport')->name('monthlyReport');

Route::post('masterReport','ReportController@masterReport')->name('masterReport');

Route::post('genrateReport','ReportController@genrateReport')->name('genrateReport');

//Dashboards
Route::post('getDashboard','ReportController@dashboard')->name('getDashboard');

//Arragements

Route::post('arrangementStore','ArrangementController@store')->name('arrangementStore');
Route::post('arrangementDelete','ArrangementController@delete')->name('arrangementDelete');

