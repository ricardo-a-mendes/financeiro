<?php

Auth::routes();

Route::get('extract/{monthToAdd?}', 'StatementController@index')->name('statement');
Route::post('extract', 'StatementController@store')->name('transaction.store');
Route::get('category-details/{categoryID}', 'StatementController@categoryDetails')->name('statement.category.details');

Route::get('/home', 'HomeController@index');

Route::resource('category', 'CategoryController', ['except' => ['show']]);
Route::resource('account', 'AccountController', ['except' => ['show']]);
Route::resource('goal', 'GoalController', ['except' => ['show']]);