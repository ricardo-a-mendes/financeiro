<?php

//use Symfony\Component\HttpKernel\Fragment\RoutableFragmentRenderer;
//TODO: Translate Everything
//TODO: Create Resumo Anual
//TODO: Create Extrato
//TODO: Use GULP to compact common CSS

Auth::routes();
Route::get('/home', 'HomeController@index');

Route::get('/', function (){
	return redirect()->route('statement');
});
Route::group(['middleware' => 'auth'], function () {
    Route::post('import-file', 'ImportController@import')->name('import.upload');
    Route::post('import', 'ImportController@store')->name('import.store');
    Route::get('statement/{monthToAdd?}', 'StatementController@index')->name('statement');
    Route::post('statement', 'StatementController@store')->name('transaction.store');
    Route::get('category-details/{categoryID}/{monthToAdd?}', 'StatementController@categoryDetails')->name('statement.category.details');
    Route::get('provision-specific-details/{categoryID}', 'ProvisionController@specificProvision')->name('provision.specific.details');

    Route::resource('category', 'CategoryController', ['except' => ['show']]);
    Route::resource('account', 'AccountController', ['except' => ['show']]);
    Route::resource('provision', 'ProvisionController', ['except' => ['show']]);
    Route::resource('reference', 'TransactionReferenceController', ['except' => ['show']]);
    Route::resource('my_account', 'UserAccountController', ['except' => ['show']]);
});