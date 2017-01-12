<?php

use Symfony\Component\HttpKernel\Fragment\RoutableFragmentRenderer;

Auth::routes();

Route::get('/', function (){
	return redirect()->route('statement');
});

Route::get('import', 'ImportController@index')->name('import');
Route::post('import', 'ImportController@store')->name('import.store');
Route::get('statement/{monthToAdd?}', 'StatementController@index')->name('statement');
Route::post('statement', 'StatementController@store')->name('transaction.store');
Route::get('category-details/{categoryID}/{monthToAdd?}', 'StatementController@categoryDetails')->name('statement.category.details');

Route::get('/home', 'HomeController@index');

Route::resource('category', 'CategoryController', ['except' => ['show']]);
Route::resource('account', 'AccountController', ['except' => ['show']]);
Route::resource('goal', 'GoalController', ['except' => ['show']]);