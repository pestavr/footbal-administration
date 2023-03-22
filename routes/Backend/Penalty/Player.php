<?php

/**
 * All route names are prefixed with 'admin.penalty.player'.
 */
Route::group([
    'prefix'     => 'player',
    'as'         => 'player.'
], function () {

    /*
     * User Management
     */
    Route::group([
        'middleware' => 'access.routeNeedsPermission:7',
    ], function () {
        Route::get('index', 'PlayerController@index')->name('index');
        Route::post('get', 'PlayerController@show')->name('get');
        Route::get('insert', 'PlayerController@insert')->name('insert');
        Route::post('do_insert', 'PlayerController@do_insert')->name('do_insert');
        Route::get('edit/{id}', 'PlayerController@edit')->name('edit');
        Route::post('update/{id}', 'PlayerController@update')->name('update');
        Route::get('show/{id}', 'PlayerController@show_modal')->name('show');
        Route::get('delete/{id}', 'PlayerController@destroy')->name('delete');
        Route::get('getHistory', 'PlayerController@history')->name('getHistory');
        Route::get('recentMatches', 'PlayerController@recentMatches')->name('recentMatches');
        Route::post('red', 'PlayerController@getRed')->name('red');
        Route::get('insertRedPenalty/{id}/{match}', 'PlayerController@insertRedPenalty')->name('insertRedPenalty');
    });
});