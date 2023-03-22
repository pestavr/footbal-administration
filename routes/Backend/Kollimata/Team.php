<?php

/**
 * All route names are prefixed with 'admin.kollimata.team'.
 */
Route::group([
    'prefix'     => 'team',
    'as'         => 'team.'
], function () {

    /*
     * User Management
     */
    Route::group([
        'middleware' => 'access.routeNeedsPermission:3;7',
    ], function () {
        Route::get('index', 'TeamController@index')->name('index');
        Route::post('get', 'TeamController@show')->name('get');
        Route::get('edit/{id}', 'TeamController@edit')->name('edit');
        Route::get('insert', 'TeamController@insert')->name('insert');
        Route::get('create', 'TeamController@create')->name('create');
        Route::post('store', 'TeamController@store')->name('store');
        Route::post('do_insert', 'TeamController@do_insert')->name('do_insert');
        Route::get('delete/{id}', 'TeamController@destroy')->name('delete');
    });
});