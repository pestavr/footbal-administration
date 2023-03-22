<?php

/**
 * All route names are prefixed with 'admin.file.court'.
 */
Route::group([
    'prefix'     => 'court',
    'as'         => 'court.'
], function () {

    /*
     * User Management
     */
    Route::group([
        'middleware' => 'access.routeNeedsPermission:7',
    ], function () {
        Route::get('index', 'CourtController@index')->name('index');
        Route::post('get', 'CourtController@show')->name('get');
        Route::get('insert', 'CourtController@insert')->name('insert');
        Route::get('show/{id}', 'CourtController@show_modal')->name('show');
        Route::get('map/{id}', 'CourtController@show_map')->name('map');
        Route::get('cities/{id}', 'CourtController@show_cities')->name('cities');
        Route::post('mapupdate/{id}', 'CourtController@map_update')->name('mapupdate');
        Route::post('citiesupdate/{id}', 'CourtController@cities_update')->name('citiesupdate');
        Route::get('deactivated', 'CourtController@deactivated')->name('deactivated');
        Route::post('get_deactivated', 'CourtController@show_deactivated')->name('get_deactivated');
        Route::post('do_insert', 'CourtController@do_insert')->name('do_insert');
        Route::get('edit/{id}', 'CourtController@edit')->name('edit');
        Route::get('deactivate/{id}', 'CourtController@deactivate')->name('deactivate');
        Route::get('activate/{id}', 'CourtController@activate')->name('activate');
        Route::post('update/{id}', 'CourtController@update')->name('update');
        Route::get('program/{id}', 'CourtController@program')->name('program');
        Route::post('getProgram/{id}', 'CourtController@get_program')->name('getProgram');
        Route::get('getCourt', 'CourtController@getCourt')->name('getCourt');
        //Route::get('show-matches', 'MatchesController@show-matches')->name('show-matches');

    });
});