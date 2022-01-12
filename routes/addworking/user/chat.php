<?php

Route::prefix('chat')->group(function () {

    Route::get('/rooms', 'MessageController@chatRoom')->name('chat.rooms');

    Route::get('/{user}/{chatRoom}/chat', 'MessageController@chat')->name('chat');

    Route::post('/save/message', 'MessageController@store')->name('chat.save_message');
});
