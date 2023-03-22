<?php

/**
 * All route names are prefixed with 'admin.referees'.
 */
Route::group([
    'prefix'     => 'referees',
    'as'         => 'referees.'
], function () {

    /*
     * User Management
     */
    Route::group([
        'middleware' => 'access.routeNeedsPermission:3',
    ], function () {
        Route::get('index', 'RefereesController@index')->name('index');
        Route::post('get', 'RefereesController@show')->name('get');
        Route::get('edit/{id}', 'RefereesController@edit')->name('edit');
        Route::get('deactivate/{id}', 'RefereesController@deactivate')->name('deactivate');
        Route::get('activate/{id}', 'RefereesController@activate')->name('activate');
        Route::post('update/{id}', 'RefereesController@update')->name('update');
        Route::get('program/{id}', 'RefereesController@program')->name('program');
        //Route::get('show-matches', 'MatchesController@show-matches')->name('show-matches');

    });
});