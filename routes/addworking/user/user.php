<?php

Route::prefix('user')->group(function () {

    Route::get('/{user}/contact-user', 'MessageController@chat')->name('user.contact');

    Route::get('/{receiver}/chat', 'MessageController@chat')->name('user.chat');

    Route::get('/{user}/save/message', 'MessageController@chat')->name('user.chat');
});

// ----------------------------------------------------------------------------
// CGU
// ----------------------------------------------------------------------------

Route::post('/terms_of_use/accepted', 'TermsOfServiceController@update')->name('terms_of_use.accepted');

Route::get('/terms_of_use/show', 'TermsOfServiceController@show')->name('terms_of_use.show');
