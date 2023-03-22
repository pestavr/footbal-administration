<?php

/**
 * All route names are prefixed with 'admin.orismos.observer'.
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
        Route::post('getMD', 'ObserverController@programMD')->name('getMD');
        Route::post('getDate', 'ObserverController@programDate')->name('getDate');
        Route::get('date', 'ObserverController@per_date')->name('date');
        Route::post('saveSelected', 'ObserverController@saveSelected')->name('saveSelected');
        Route::get('openCourtCheck', 'ObserverController@openCourtCheck')->name('openCourtCheck');
        Route::post('courtCheck', 'ObserverController@courtCheck')->name('courtCheck');
        Route::get('checkDays', 'ObserverController@checkDays')->name('checkDays');
        Route::get('checkRefBlock', 'ObserverController@checkRefBlock')->name('checkRefBlock');
        Route::get('checkTeamBlock', 'ObserverController@checkTeamBlock')->name('checkTeamBlock');
        Route::get('checkOtherMatch', 'ObserverController@checkOtherMatch')->name('checkOtherMatch');
        Route::get('save', 'ObserverController@save')->name('save');
        Route::get('team1', 'ObserverController@team1')->name('team1');
        Route::get('team2', 'ObserverController@team2')->name('team2');
        Route::get('savePubl', 'ObserverController@savePubl')->name('savePubl');
        Route::get('saveNof', 'ObserverController@saveNof')->name('saveNof');
        //Route::get('show-matches', 'MatchesController@show-matches')->name('show-matches');

    });
});