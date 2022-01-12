<?php

// ----------------------------------------------------------------------------
// Passworks
// ----------------------------------------------------------------------------

Route::get(
    '/passwork/export',
    'User\\PassworkController@export'
)->name(
    'passwork.export'
);

Route::get(
    '/passwork/pending',
    'User\\PassworkController@pending'
)->name(
    'passwork.pending'
);

Route::get(
    'passwork/{passwork}/file/create',
    'User\\PassworkFileController@create'
)->name(
    'passwork.create-file'
);

Route::get(
    'passwork/{passwork}/file/{file}',
    'User\\PassworkFileController@show'
)->name(
    'passwork.show-file'
);

Route::put(
    '/passwork/{passwork}/status',
    'User\\PassworkController@status'
)->name(
    'passwork.status'
);

Route::put(
    '/passwork/{passwork}/parking',
    'User\\PassworkController@parking'
)->name(
    'passwork.parking'
);

Route::put(
    '/passwork/{passwork}/contacted',
    'User\\PassworkController@contacted'
)->name(
    'passwork.contacted'
);

Route::post(
    '/passwork/{passwork}/share',
    'User\\PassworkController@share'
)->name(
    'passwork.share'
);

Route::resource(
    'passwork',
    'User\\PassworkController'
);

Route::get(
    'passwork/{passwork}/attach',
    'User\\PassworkController@attachToErymaOrSubsidiaries'
)->name(
    'passwork.attach'
);

// ----------------------------------------------------------------------------
// Passworks quizzes
// ----------------------------------------------------------------------------

Route::resource(
    'passwork.quizz',
    'User\\QuizzController'
);

// ----------------------------------------------------------------------------
// Passworks search
// ----------------------------------------------------------------------------

Route::resource(
    'saved_search',
    'User\\PassworkSavedSearchController'
);

Route::post(
    '/saved_search/{saved_search}/schedule',
    'User\\PassworkSavedSearchController@schedule'
)->name(
    'user.passwork.saved.search.schedule'
);
