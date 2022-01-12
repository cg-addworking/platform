<?php

Route::prefix('notifications')->group(function () {

    Route::get('/{notification_preferences}/edit', 'NotificationPreferencesController@edit')
        ->name('addworking.user.notification_preferences.edit');

    Route::put('/{notification_preferences}', 'NotificationPreferencesController@update')
        ->name('addworking.user.notification_preferences.update');
});
