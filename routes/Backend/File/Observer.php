<?php

/**
 * All route names are prefixed with 'admin.file.observer'.
 */
Route::group([
    'prefix'     => 'observer',
    'as'         => 'observer.'
], function () {

    /*
     * User Management
     */
    Route::group([
        'middleware' => 'access.routeNeedsPermission:7',
    ], function () {
        Route::get('index', 'ObserverController@index')->name('index');
        Route::post('get', 'ObserverController@show')->name('get');
        Route::get('insert', 'ObserverController@insert')->name('insert');
        Route::get('deactivated', 'ObserverController@deactivated')->name('deactivated');
        Route::post('get_deactivated', 'ObserverController@show_deactivated')->name('get_deactivated');
        Route::post('do_insert', 'ObserverController@do_insert')->name('do_insert');
        Route::get('edit/{id}', 'ObserverController@edit')->name('edit');
        Route::get('deactivate/{id}', 'ObserverController@deactivate')->name('deactivate');
        Route::get('activate/{id}', 'ObserverController@activate')->name('activate');
        Route::post('update/{id}', 'ObserverController@update')->name('update');
        Route::get('program/{id}', 'ObserverController@program')->name('program');
        Route::post('getProgram/{id}', 'ObserverController@get_program')->name('getProgram');
        Route::get('show/{id}', 'ObserverController@show_modal')->name('show');
        Route::get('getObserver', 'ObserverController@getObserver')->name('getObserver');
        //Route::get('show-matches', 'MatchesController@show-matches')->name('show-matches');

    });
});