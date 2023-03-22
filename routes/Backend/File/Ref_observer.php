<?php

/**
 * All route names are prefixed with 'admin.file.ref_observer'.
 */
Route::group([
    'prefix'     => 'ref_observer',
    'as'         => 'ref_observer.'
], function () {

    /*
     * User Management
     */
    Route::group([
        'middleware' => 'access.routeNeedsPermission:7',
    ], function () {
        Route::get('index', 'Ref_observerController@index')->name('index');
        Route::post('get', 'Ref_observerController@show')->name('get');
        Route::get('insert', 'Ref_observerController@insert')->name('insert');
        Route::get('deactivated', 'Ref_observerController@deactivated')->name('deactivated');
        Route::post('get_deactivated', 'Ref_observerController@show_deactivated')->name('get_deactivated');
        Route::post('do_insert', 'Ref_observerController@do_insert')->name('do_insert');
        Route::get('edit/{id}', 'Ref_observerController@edit')->name('edit');
        Route::get('deactivate/{id}', 'Ref_observerController@deactivate')->name('deactivate');
        Route::get('activate/{id}', 'Ref_observerController@activate')->name('activate');
        Route::post('update/{id}', 'Ref_observerController@update')->name('update');
        Route::get('program/{id}', 'Ref_observerController@program')->name('program');
        Route::post('getProgram/{id}', 'Ref_ObserverController@get_program')->name('getProgram');
        Route::get('show/{id}', 'Ref_observerController@show_modal')->name('show');
        //Route::get('show-matches', 'MatchesController@show-matches')->name('show-matches');

    });
    Route::group([
        'middleware' => 'access.routeNeedsPermission:3;7',
    ], function () {
        
        Route::get('getrefObserver', 'Ref_observerController@getrefObserver')->name('getrefObserver');

    });
});