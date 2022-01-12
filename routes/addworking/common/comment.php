<?php

// ----------------------------------------------------------------------------
// Comment
// ----------------------------------------------------------------------------

use Illuminate\Support\Facades\Route;

Route::resource('comment', 'CommentController')
    ->only(['store', 'destroy']);

Route::post("comment/get-users-to-notify", [
    'uses' => 'CommentController@getUsersToNotify',
    'as' => 'comment.get_users_to_notify'
]);
