<?php

// ----------------------------------------------------------------------------
// Mission
// ----------------------------------------------------------------------------

Route::get(
    '/mission/import',
    'MissionController@import'
)->name(
    'mission.import'
);

Route::post(
    '/mission/load',
    'MissionController@load'
)->name(
    'mission.load'
);
