<?php

Auth::routes();

Route::get('/{monthToAdd?}', 'StatementController@index')->name('statement');
Route::get('category-details/{categoryID}', 'StatementController@categoryDetails')->name('statement.category.details');

Route::get('/home', 'HomeController@index');

Route::resource('category', 'CategoryController', ['except' => ['show']]);
Route::resource('account', 'AccountController', ['except' => ['show']]);
Route::resource('goal', 'GoalController', ['except' => ['show']]);