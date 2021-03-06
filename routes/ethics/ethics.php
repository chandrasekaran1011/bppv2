<?php

Route::get('/ethics', 'EthicsController@index')->name('index');

Route::post('/getFormData', 'EthicsController@getFormData')->name('getFormData');

Route::post('storePublicForm','EthicsController@storePublicForm')->name('storePublicForm')->middleware('can:Create Partner');

Route::post('storeOtherForm','EthicsController@storeOtherForm')->name('storeOtherForm')->middleware('can:Create Partner');;

Route::post('storePmForm','EthicsController@storePmForm')->name('storePmForm')->middleware('can:Create Partner');;
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

Route::post('searchResult','SearchController@searchResult')->name('searchResult')->middleware('can:Search Partner');

Route::post('questionnaireNotSubmitted','EthicsController@questionnaireNotSubmitted')->name('questionnaireNotSubmitted');

Route::post('deletePartner','EthicsController@deletePartner')->name('deletePartner')->middleware('can:Delete Partner');


Route::post('uploadFile','EthicsController@uploadFile')->name('uploadFile');

Route::post('viewFiles','EthicsController@viewFiles')->name('viewFiles');

//Edit

Route::post('getEdit','EditController@getEdit')->name('getEdit');
Route::post('updatePartner','EditController@updatePartner')->name('updatePartner');


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

Route::post('monthlyReport','ReportController@monthlyReport')->name('monthlyReport')->middleware('can:Generate Reports');

Route::post('masterReport','ReportController@masterReport')->name('masterReport')->middleware('can:Generate Reports');

Route::post('cdoReport','ReportController@cdoReport')->name('cdoReport')->middleware('can:Generate Reports');

Route::post('genrateReport','ReportController@genrateReport')->name('genrateReport');

//Dashboards
Route::post('getDashboard','ReportController@dashboard')->name('getDashboard');

//Arragements

Route::post('arrangementStore','ArrangementController@store')->name('arrangementStore');
Route::post('arrangementDelete','ArrangementController@delete')->name('arrangementDelete');

//Pursuance
Route::post('pursuance','EthicsController@pursuance')->name('pursuance');
