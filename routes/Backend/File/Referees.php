<?php

/**
 * All route names are prefixed with 'admin.file.referees'.
 */
Route::group([
    'prefix'     => 'referees',
    'as'         => 'referees.'
], function () {

    /*
     * User Management
     */
    Route::group([
        'middleware' => 'access.routeNeedsPermission:3;7'
    ], function () {
        Route::get('index', 'RefereesController@index')->name('index');
        Route::post('get', 'RefereesController@show')->name('get');
        Route::get('insert', 'RefereesController@insert')->name('insert');
        Route::get('deactivated', 'RefereesController@deactivated')->name('deactivated');
        Route::post('get_deactivated', 'RefereesController@show_deactivated')->name('get_deactivated');
        Route::post('do_insert', 'RefereesController@do_insert')->name('do_insert');
        Route::get('edit/{id}', 'RefereesController@edit')->name('edit');
        Route::get('deactivate/{id}', 'RefereesController@deactivate')->name('deactivate');
        Route::get('activate/{id}', 'RefereesController@activate')->name('activate');
        Route::post('update/{id}', 'RefereesController@update')->name('update');
        Route::get('program/{id}', 'RefereesController@program')->name('program');
        Route::get('show/{id}', 'RefereesController@show_modal')->name('show');
        Route::get('getreferee', 'RefereesController@getReferee')->name('getReferee');
        Route::get('refStats/{referee}', 'RefereesController@refStats')->name('refStats');
        Route::get('mass_store', 'RefereesController@massStore')->name('mass_store');
    });
    Route::group([
        'middleware' => 'access.routeNeedsPermission:4',
    ], function () {
        Route::get('referees', 'RefereesController@referees')->name('referees');
        Route::post('tel', 'RefereesController@tel')->name('tel');

    });
});