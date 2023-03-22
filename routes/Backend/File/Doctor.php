<?php

/**
 * All route names are prefixed with 'admin.file.doctor'.
 */
Route::group([
    'prefix'     => 'doctor',
    'as'         => 'doctor.'
], function () {

    /*
     * User Management
     */
    Route::group([
        'middleware' => 'access.routeNeedsPermission:7',
    ], function () {
        Route::get('index', 'DoctorController@index')->name('index');
        Route::post('get', 'DoctorController@show')->name('get');
        Route::get('insert', 'DoctorController@insert')->name('insert');
        Route::get('deactivated', 'DoctorController@deactivated')->name('deactivated');
        Route::post('get_deactivated', 'DoctorController@show_deactivated')->name('get_deactivated');
        Route::post('do_insert', 'DoctorController@do_insert')->name('do_insert');
        Route::get('edit/{id}', 'DoctorController@edit')->name('edit');
        Route::get('deactivate/{id}', 'DoctorController@deactivate')->name('deactivate');
        Route::get('activate/{id}', 'DoctorController@activate')->name('activate');
        Route::post('update/{id}', 'DoctorController@update')->name('update');
        Route::get('program/{id}', 'DoctorController@program')->name('program');
        Route::post('getProgram/{id}', 'DoctorController@get_program')->name('getProgram');
        Route::get('show/{id}', 'DoctorController@show_modal')->name('show');
        Route::get('getDoctor', 'DoctorController@getDoctor')->name('getDoctor');
        //Route::get('show-matches', 'MatchesController@show-matches')->name('show-matches');

    });
});