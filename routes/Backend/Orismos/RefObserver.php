<?php

/**
 * All route names are prefixed with 'admin.orismos.refObserver'.
 */
Route::group([
    'prefix'     => 'refObserver',
    'as'         => 'refObserver.'
], function () {

    /*
     * User Management
     */
    Route::group([
        'middleware' => 'access.routeNeedsPermission:3',
    ], function () {
        Route::get('index', 'RefObserverController@index')->name('index');
        Route::post('get', 'RefObserverController@show')->name('get');
        Route::post('getMD', 'RefObserverController@programMD')->name('getMD');
        Route::post('getDate', 'RefObserverController@programDate')->name('getDate');
        Route::get('date', 'RefObserverController@per_date')->name('date');
        Route::post('saveSelected', 'RefObserverController@saveSelected')->name('saveSelected');
        Route::get('openCourtCheck', 'RefObserverController@openCourtCheck')->name('openCourtCheck');
        Route::post('courtCheck', 'RefObserverController@courtCheck')->name('courtCheck');
        Route::get('checkDays', 'RefObserverController@checkDays')->name('checkDays');
        Route::get('checkRefBlock', 'RefObserverController@checkRefBlock')->name('checkRefBlock');
        Route::get('checkTeamBlock', 'RefObserverController@checkTeamBlock')->name('checkTeamBlock');
        Route::get('checkOtherMatch', 'RefObserverController@checkOtherMatch')->name('checkOtherMatch');
        Route::get('save', 'RefObserverController@save')->name('save');
        Route::get('team1', 'RefObserverController@team1')->name('team1');
        Route::get('team2', 'RefObserverController@team2')->name('team2');
        Route::get('savePubl', 'RefObserverController@savePubl')->name('savePubl');
        Route::get('saveNof', 'RefObserverController@saveNof')->name('saveNof');
        //Route::get('show-matches', 'MatchesController@show-matches')->name('show-matches');

    });
});