<?php

/**
 * All route names are prefixed with 'admin.orismos.referee'.
 */
Route::group([
    'prefix'     => 'referee',
    'as'         => 'referee.'
], function () {

    /*
     * User Management
     */
    Route::group([
        'middleware' => 'access.routeNeedsPermission:3',
    ], function () {
        Route::get('index', 'RefereeController@index')->name('index');
        Route::post('get', 'RefereeController@show')->name('get');
        Route::post('getMD', 'RefereeController@programMD')->name('getMD');
        Route::post('getDate', 'RefereeController@programDate')->name('getDate');
        Route::get('date', 'RefereeController@per_date')->name('date');
        Route::post('saveSelected', 'RefereeController@saveSelected')->name('saveSelected');
        Route::get('openCourtCheck', 'RefereeController@openCourtCheck')->name('openCourtCheck');
        Route::post('courtCheck', 'RefereeController@courtCheck')->name('courtCheck');
        Route::get('checkDays', 'RefereeController@checkDays')->name('checkDays');
        Route::get('checkRefBlock', 'RefereeController@checkRefBlock')->name('checkRefBlock');
        Route::get('checkTeamBlock', 'RefereeController@checkTeamBlock')->name('checkTeamBlock');
        Route::get('checkOtherMatch', 'RefereeController@checkOtherMatch')->name('checkOtherMatch');
        Route::get('save', 'RefereeController@save')->name('save');
        Route::get('team1', 'RefereeController@team1')->name('team1');
        Route::get('team2', 'RefereeController@team2')->name('team2');
        Route::get('savePubl', 'RefereeController@savePubl')->name('savePubl');
        Route::get('saveNof', 'RefereeController@saveNof')->name('saveNof');
        Route::get('epoReport', 'RefereeController@epoReport')->name('epoReport');
        Route::post('showEpoReport', 'RefereeController@showEpoReport')->name('showEpoReport');
        //Route::get('show-matches', 'MatchesController@show-matches')->name('show-matches');

    });

    Route::group([
        'middleware' => 'access.routeNeedsPermission:4',
    ], function () { 
        Route::get('accept/{match}', 'RefereeController@accept')->name('accept');
        Route::get('refuse/{match}', 'RefereeController@refuse')->name('refuse');
    });

});

    Route::group(['namespace' => 'Grades', 'prefix' => 'referee', 'as' => 'referee.', 'middleware' => 'admin'], function () {
    /*
     * These routes need view-backend permission
     * (good if you want to allow more than one group in the backend,
     * then limit the backend features by different roles or permissions)
     *
     * Note: Administrator has all permissions so you do not have to specify the administrator role everywhere.
     */
    includeRouteFiles(__DIR__.'/Grades/');
    });