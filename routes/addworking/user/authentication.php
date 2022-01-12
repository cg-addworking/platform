<?php

Auth::routes();

Route::get('/dashboard', 'DashboardController@index')->name('dashboard')->middleware('auth');

Route::view('/sogetrel/login', 'sogetrel.user.login')->name('sogetrel.login');

Route::impersonate();
