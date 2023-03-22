<?php

/**
 * All route names are prefixed with 'admin.file.team'.
 */
Route::group([
    'prefix'     => 'team',
    'as'         => 'team.'
], function () {

    /*
     * User Management
     */
    Route::group([
        'middleware' => 'access.routeNeedsPermission:7;3',
    ], function () {
        Route::get('index', 'TeamController@index')->name('index');
        Route::post('get', 'TeamController@show')->name('get');
        Route::get('insert', 'TeamController@insert')->name('insert');
        Route::get('deactivated', 'TeamController@deactivated')->name('deactivated');
        Route::post('get_deactivated', 'TeamController@show_deactivated')->name('get_deactivated');
        Route::post('do_insert', 'TeamController@do_insert')->name('do_insert');
        Route::get('edit/{id}', 'TeamController@edit')->name('edit');
        Route::get('deactivate/{id}', 'TeamController@deactivate')->name('deactivate');
        Route::get('activate/{id}', 'TeamController@activate')->name('activate');
        Route::post('update/{id}', 'TeamController@update')->name('update');
        Route::get('program/{id}', 'TeamController@program')->name('program');
        Route::get('show/{id}', 'TeamController@show_modal')->name('show');
        Route::get('ds/{id}', 'TeamController@ds_edit')->name('ds');
        Route::get('getTeamsPerAgeLevel', 'TeamController@getTeamsPerAgeLevel')->name('getTeamsPerAgeLevel');
        Route::get('getTeamsAutocomplete', 'TeamController@getTeamsAutocomplete')->name('getTeamsAutocomplete');

        //Route::get('show-matches', 'MatchesController@show-matches')->name('show-matches');

    });
});