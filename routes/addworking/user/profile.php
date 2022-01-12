<?php

Route::prefix('profile')->group(function () {

    Route::get('/', 'ProfileController@index')->name('profile');

    Route::get('/edit', 'ProfileController@edit')->name('profile.edit');

    Route::post('/save', 'ProfileController@update')->name('profile.update');

    Route::get('/customers', 'ProfileController@customers')->name('profile.customers');

    Route::get('/edit/email', 'ProfileController@editEmail')->name('profile.edit_email');

    Route::post('/save/email', 'ProfileController@storeEmail')->name('profile.save_email');

    Route::get('/edit/password', 'ProfileController@editPassword')->name('profile.edit_password');

    Route::post('/save/password', 'ProfileController@storePassword')->name('profile.save_password');
});
