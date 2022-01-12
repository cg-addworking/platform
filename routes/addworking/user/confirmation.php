<?php

Route::prefix('confirmation')->group(function () {

    Route::get('/pending', 'Auth\ConfirmationController@confirmation')->name('confirmation.pending');

    Route::get('/resend', 'Auth\ConfirmationController@resend')->name('confirmation.resend')->middleware('auth');

    Route::get('/force', 'Auth\ConfirmationController@force')->name('confirmation.force')->middleware('auth');

    Route::get('/{token}', 'Auth\ConfirmationController@confirm')->name('confirmation');
});
