<?php

/**
 * All route names are prefixed with 'admin.penalty.team'.
 */
Route::group([
    'prefix'     => 'team',
    'as'         => 'team.'
], function () {

    /*
     * User Management
     */
    Route::group([
        'middleware' => 'access.routeNeedsPermission:7',
    ], function () {
        Route::get('index', 'TeamController@index')->name('index');
        Route::post('get', 'TeamController@show')->name('get');
        Route::get('insert', 'TeamController@insert')->name('insert');
        Route::post('do_insert', 'TeamController@do_insert')->name('do_insert');
        Route::get('edit/{id}', 'TeamController@edit')->name('edit');
        Route::post('update/{id}', 'TeamController@update')->name('update');
        Route::get('show/{id}', 'TeamController@show_modal')->name('show');
        Route::get('delete/{id}', 'TeamController@destroy')->name('delete');
        Route::get('getHistory', 'TeamController@history')->name('getHistory');
        Route::get('recentMatches', 'TeamController@recentMatches')->name('recentMatches');

    });
});