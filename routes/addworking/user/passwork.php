<?php

Route::prefix('passwork')->name('passwork.')->group(function () {

    Route::post('/save', 'PassworkController@save')->name('save');

    Route::prefix('{passwork}')->group(function () {

        Route::put('/status', 'PassworkController@status')->name('status');

        Route::put('/parking', 'PassworkController@parking')->name('parking');

        Route::put('/contacted', 'PassworkController@contacted')->name('contacted');

        Route::put('/comment', 'PassworkController@comment')->name('comment');
    });
});
