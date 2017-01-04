<?php

Auth::routes();

Route::get('/', 'StatementController@index')->name('statement');
Route::get('category-details/{categoryID}', 'StatementController@categoryDetails')->name('statement.category.details');

Route::get('/home', 'HomeController@index');