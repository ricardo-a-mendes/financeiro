<?php

//use Symfony\Component\HttpKernel\Fragment\RoutableFragmentRenderer;
//TODO: Translate Everything
//TODO: Create Resumo Anual
//TODO: Create Extrato
//TODO: Use GULP to compact common CSS

$yearMonthPattern = '(2\d{3}|19\d{2})(1[0-2]|0[1-9])';
Route::pattern('yearMonth', $yearMonthPattern);

Auth::routes();
Route::get('/home', 'HomeController@index');

Route::get('/', function (){
	return redirect()->route('statement');
});
Route::group(['middleware' => 'auth'], function () use ($yearMonthPattern) {
    Route::post('import-file', 'ImportController@import')->name('import.upload');
    Route::post('import', 'ImportController@store')->name('import.store');
    Route::get('statement-monthly', 'StatementController@index')->name('statement');
    Route::post('statement-monthly', 'StatementController@index')->name('statement.monthly');
    Route::get('statement-yearly', 'StatementController@yearly')->name('statement.yearly');
    Route::post('statement-yearly', 'StatementController@yearly')->name('statement.yearly.filter');
    Route::post('statement', 'StatementController@store')->name('transaction.store');
    Route::get('category-details/{categoryID}/{yearMonth?}', 'StatementController@categoryDetails')->name('statement.category.details');
    Route::get('provision-specific-details/{categoryID}', 'ProvisionController@specificProvision')->name('provision.specific.details');

    Route::resource('category', 'CategoryController', ['except' => ['show']]);
    //Route::resource('account', 'AccountController', ['except' => ['show']]);
    Route::resource('provision', 'ProvisionController', ['except' => ['show']]);//->middleware('can:view,App\Model\Provision');
    Route::resource('reference', 'TransactionReferenceController', ['except' => ['show']]);
    Route::resource('my_account', 'UserAccountController', ['except' => ['show']]);
});
