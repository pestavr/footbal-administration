<?php

/**
 * All route names are prefixed with 'admin.penalty.official'.
 */
Route::group([
    'prefix'     => 'official',
    'as'         => 'official.'
], function () {

    /*
     * User Management
     */
    Route::group([
        'middleware' => 'access.routeNeedsPermission:7',
    ], function () {
        Route::get('index', 'OfficialController@index')->name('index');
        Route::post('get', 'OfficialController@show')->name('get');
        Route::get('insert', 'OfficialController@insert')->name('insert');
        Route::post('do_insert', 'OfficialController@do_insert')->name('do_insert');
        Route::get('edit/{id}', 'OfficialController@edit')->name('edit');
        Route::post('update/{id}', 'OfficialController@update')->name('update');
        Route::get('show/{id}', 'OfficialController@show_modal')->name('show');
        Route::get('delete/{id}', 'OfficialController@destroy')->name('delete');
        Route::get('getHistory', 'OfficialController@history')->name('getHistory');
        Route::get('recentMatches', 'OfficialController@recentMatches')->name('recentMatches');

    });
});