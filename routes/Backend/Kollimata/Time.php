<?php

/**
 * All route names are prefixed with 'admin.kollimata.time'.
 */
Route::group([
    'prefix'     => 'time',
    'as'         => 'time.'
], function () {

    /*
     * User Management
     */
    Route::group([
        'middleware' => 'access.routeNeedsPermission:4',
    ], function () {
        //Ανά Διαιτητή
        Route::get('myKollimata', 'TimeController@myKollimata')->name('myKollimata');
         Route::post('getPerRef', 'TimeController@getPerRef')->name('getPerRef');
    });
     Route::group([
        'middleware' => 'access.routeNeedsPermission:3',
        'middleware' => 'access.routeNeedsPermission:4',
    ], function () {

        Route::get('delete/{id}', 'TimeController@destroy')->name('delete');
        Route::post('timeForms', 'TimeController@timeForms')->name('timeForms');
    });
    Route::group([
        'middleware' => 'access.routeNeedsPermission:3;7'
    ], function () {
        Route::get('index', 'TimeController@index')->name('index');
        Route::post('get', 'TimeController@show')->name('get');
        Route::get('edit/{id}', 'TimeController@edit')->name('edit');
        Route::get('update/{id}', 'TimeController@update')->name('update');
        Route::get('insert', 'TimeController@insert')->name('insert');
        Route::post('do_insert', 'TimeController@do_insert')->name('do_insert');
    });
});