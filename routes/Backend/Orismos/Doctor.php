<?php

/**
 * All route names are prefixed with 'admin.orismos.doctor'.
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
        Route::post('getMD', 'DoctorController@programMD')->name('getMD');
        Route::post('getDate', 'DoctorController@programDate')->name('getDate');
        Route::get('date', 'DoctorController@per_date')->name('date');
        Route::post('saveSelected', 'DoctorController@saveSelected')->name('saveSelected');
        Route::get('openCourtCheck', 'DoctorController@openCourtCheck')->name('openCourtCheck');
        Route::post('courtCheck', 'DoctorController@courtCheck')->name('courtCheck');
        Route::get('checkDays', 'DoctorController@checkDays')->name('checkDays');
        Route::get('checkRefBlock', 'DoctorController@checkRefBlock')->name('checkRefBlock');
        Route::get('checkTeamBlock', 'DoctorController@checkTeamBlock')->name('checkTeamBlock');
        Route::get('checkOtherMatch', 'DoctorController@checkOtherMatch')->name('checkOtherMatch');
        Route::get('save', 'DoctorController@save')->name('save');
        Route::get('team1', 'DoctorController@team1')->name('team1');
        Route::get('team2', 'DoctorController@team2')->name('team2');
        Route::get('savePubl', 'DoctorController@savePubl')->name('savePubl');
        Route::get('saveNof', 'DoctorController@saveNof')->name('saveNof');
        //Route::get('show-matches', 'MatchesController@show-matches')->name('show-matches');

    });
});