<?php

/**
 * All route names are prefixed with 'admin.file.teamsAccountable'.
 */
Route::group([
    'prefix'     => 'teamsAccountable',
    'as'         => 'teamsAccountable.'
], function () {

    /*
     * User Management
     */
    Route::group([
        'middleware' => 'access.routeNeedsPermission:7',
    ], function () {
        Route::get('index', 'TeamsAccountableController@index')->name('index');
        Route::post('get', 'TeamsAccountableController@show')->name('get');
        Route::get('insert', 'TeamsAccountableController@insert')->name('insert');
        Route::get('deactivated', 'TeamsAccountableController@deactivated')->name('deactivated');
        Route::post('get_deactivated', 'TeamsAccountableController@show_deactivated')->name('get_deactivated');
        Route::post('do_insert', 'TeamsAccountableController@do_insert')->name('do_insert');
        Route::get('edit/{id}', 'TeamsAccountableController@edit')->name('edit');
        Route::get('deactivate/{id}', 'TeamsAccountableController@deactivate')->name('deactivate');
        Route::get('activate/{id}', 'TeamsAccountableController@activate')->name('activate');
        Route::post('update/{id}', 'TeamsAccountableController@update')->name('update');
        Route::get('program/{id}', 'TeamsAccountableController@program')->name('program');
        Route::get('show/{id}', 'TeamsAccountableController@show_modal')->name('show');
        Route::get('team/{id}', 'TeamsAccountableController@per_team')->name('team');
        Route::post('get_per_team/{id}', 'TeamsAccountableController@show_per_team')->name('get_per_team');
        Route::get('getPlayer', 'TeamsAccountableController@getPlayer')->name('getPlayer');
        //Route::get('show-matches', 'MatchesController@show-matches')->name('show-matches');

    });
});