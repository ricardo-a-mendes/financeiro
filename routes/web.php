<?php

Auth::routes();

Route::get('statement/{monthToAdd?}', 'StatementController@index')->name('statement');
Route::post('statement', 'StatementController@store')->name('transaction.store');
Route::get('category-details/{categoryID}/{monthToAdd?}', 'StatementController@categoryDetails')->name('statement.category.details');

Route::get('/home', 'HomeController@index');

Route::resource('category', 'CategoryController', ['except' => ['show']]);
Route::resource('account', 'AccountController', ['except' => ['show']]);
Route::resource('goal', 'GoalController', ['except' => ['show']]);