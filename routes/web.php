<?php

use Illuminate\Http\Request;

Route::get('/', function () {
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    if (auth()->user()->isSupport()) {
        return redirect()->route('user.index');
    }

    return redirect()->route('dashboard');
})->name('welcome');

Route::view('403', 'errors.403');
Route::view('404', 'errors.404');
Route::view('500', 'errors.500');
Route::view('501', 'errors.501');

// ----------------------------------------------------------------------------
// Miscelaneous
// ----------------------------------------------------------------------------

Route::view('/sogetrel/landing', 'sogetrel.landing');

Route::prefix('comments')->name('comment.')->group(function () {

    Route::post('/store', 'CommentController@store')->name('store');

    Route::get('/{comment}/destroy', 'CommentController@destroy')->name('destroy');
});

Route::prefix('address')->group(function () {

    Route::get('/', 'Common\AddressController@index')->name('address.index');

    Route::get('/add', 'Common\AddressController@create')->name('address.create');

    Route::post('/save', 'Common\AddressController@store')->name('address.save');

    Route::get('/{address}', 'Common\AddressController@show')->name('address.view');

    Route::get('/{address}/edit', 'Common\AddressController@edit')->name('address.edit');

    Route::get('/{address}/delete', 'Common\AddressController@destroy')->name('address.delete');

    Route::delete('/{address}/{enterprise}/detach', 'Common\AddressController@detach')->name('address.detach');
});

Route::get('/format/float_to_money', function (Request $request) {
    if ($request->has('string')) {
        return float_to_money($request->input('string'));
    }
});

Route::get('/format/money_to_float', function (Request $request) {
    if ($request->has('number')) {
        return money_to_float($request->input('number'));
    }
});
