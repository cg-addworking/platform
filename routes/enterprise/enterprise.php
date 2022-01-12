<?php

// --------------------------------------------------------------------------------------------------------------------
// LEGACY
// --------------------------------------------------------------------------------------------------------------------

/**
 * @todo refactor these routes
 */

Route::prefix('enterprise')->group(function () {

    Route::get('/', 'EnterpriseController@index')->name('enterprise.index');

    Route::get('/add', 'EnterpriseController@create')->name('enterprise.add');

    Route::post('/store', 'EnterpriseController@store')->name('enterprise.store');

    Route::post('/finder', 'EnterpriseController@finder')->name('enterprise.finder');

    Route::prefix('{enterprise}')->group(function () {

        Route::get('/', 'EnterpriseController@show')->name('enterprise.show');

        Route::get('/edit', 'EnterpriseController@edit')->name('enterprise.edit');

        Route::post('/update', 'EnterpriseController@update')->name('enterprise.update');

        Route::delete('/destroy', 'EnterpriseController@destroy')->name('enterprise.destroy');

        Route::resource('subsidiaries', 'SubsidiaryEnterpriseController')->except(['show', 'edit']);
    });
});

// ----------------------------------------------------------------------------
// IBAN
// ----------------------------------------------------------------------------

Route::get('enterprise/{enterprise}/iban/{iban}/confirm', 'EnterpriseIbanController@confirm')
    ->name('enterprise.iban.confirm');

Route::get('enterprise/{enterprise}/iban/{iban}/cancel', 'EnterpriseIbanController@cancel')
    ->name('enterprise.iban.cancel');

Route::get('enterprise/{enterprise}/iban/{iban}/resend', 'EnterpriseIbanController@resend')
    ->name('enterprise.iban.resend');

Route::resource('enterprise.iban', 'EnterpriseIbanController')->except(['index', 'edit']);
