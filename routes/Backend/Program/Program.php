<?php

/**
 * All route names are prefixed with 'admin.program.program'.
 */
Route::group([
    'prefix'     => 'program',
    'as'         => 'program.'
], function () {

    /*
     * User Management
     */
    Route::group([
        'middleware' => 'access.routeNeedsPermission:7',
    ], function () {
        Route::get('index', 'ProgramController@index')->name('index');
        Route::post('get', 'ProgramController@show')->name('get');
        Route::post('getMD', 'ProgramController@programMD')->name('getMD');
        Route::post('getDate', 'ProgramController@programDate')->name('getDate');
        Route::get('date', 'ProgramController@per_date')->name('date');
        Route::post('saveSelected', 'ProgramController@saveSelected')->name('saveSelected');
        Route::get('openCourtCheck', 'ProgramController@openCourtCheck')->name('openCourtCheck');
        Route::post('courtCheck', 'ProgramController@courtCheck')->name('courtCheck');
        Route::post('matchesWithOutScore', 'ProgramController@matchesWithOutScore')->name('matchesWithOutScore');
        Route::get('changeTeams/{id}', 'ProgramController@changeTeams')->name('changeTeams');
        Route::post('teamsUpdate/{id}', 'ProgramController@teamsUpdate')->name('teamsUpdate');
        Route::get('postpone/{id}', 'ProgramController@postpone')->name('postpone');
        Route::get('depostpone/{id}', 'ProgramController@depostpone')->name('depostpone');
        Route::get('insertLink/{id}', 'ProgramController@insertLink')->name('insertLink');
        Route::post('linkUpdate/{id}', 'ProgramController@linkUpdate')->name('linkUpdate');
        Route::get('resetMatch/{id}', 'ProgramController@resetMatch')->name('resetMatch');
    });
    Route::group([
        'middleware' => 'access.routeNeedsPermission:7;4',
    ], function () {
        Route::get('score/{id}', 'ProgramController@score')->name('score');
        Route::post('scoreUpdate/{id}', 'ProgramController@scoreUpdate')->name('scoreUpdate');
    });
    Route::group([
        'middleware' => 'access.routeNeedsPermission:4',
    ], function () {
        Route::get('myMatches', 'ProgramController@myMatches')->name('myMatches');
        Route::post('getMyMatches', 'ProgramController@getMyMatches')->name('getMyMatches');
    });
    Route::group([
        'middleware' => 'access.routeNeedsPermission:5',
    ], function () {
        Route::get('myObserverMatches', 'ProgramController@myObserverMatches')->name('myObserverMatches');
        Route::post('getMyObserverMatches', 'ProgramController@getMyObserverMatches')->name('getMyObserverMatches');
    });
});