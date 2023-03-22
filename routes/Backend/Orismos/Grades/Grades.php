<?php

/**
 * All route names are prefixed with 'admin.orismos.referee.grades'.
 */
Route::group([
    'prefix'     => 'grades',
    'as'         => 'grades.'
], function () {

    Route::group([        
        'middleware' => 'access.routeNeedsPermission:4'
    ], function () {
        Route::get('matchGrades/{id}', 'GradesController@matchGrades')->name('matchGrades');
        

    });

    /*
     * User Management
     */
    Route::group([
        'middleware' => 'access.routeNeedsPermission:3',
    ], function () {
        Route::get('index', 'GradesController@index')->name('index');
        Route::post('get', 'GradesController@show')->name('get');
        Route::post('getMD', 'GradesController@programMD')->name('getMD');
        Route::post('getDate', 'GradesController@programDate')->name('getDate');
        Route::get('date', 'GradesController@per_date')->name('date');
        Route::post('saveSelected', 'GradesController@saveSelected')->name('saveSelected');
        Route::get('openCourtCheck', 'GradesController@openCourtCheck')->name('openCourtCheck');
        Route::post('courtCheck', 'GradesController@courtCheck')->name('courtCheck');
        Route::get('checkDays', 'GradesController@checkDays')->name('checkDays');
        Route::get('checkRefBlock', 'GradesController@checkRefBlock')->name('checkRefBlock');
        Route::get('checkTeamBlock', 'GradesController@checkTeamBlock')->name('checkTeamBlock');
        Route::get('checkOtherMatch', 'GradesController@checkOtherMatch')->name('checkOtherMatch');
        Route::get('save', 'GradesController@save')->name('save');
        Route::get('team1', 'GradesController@team1')->name('team1');
        Route::get('team2', 'GradesController@team2')->name('team2');
        Route::get('savePubl', 'GradesController@savePubl')->name('savePubl');
        Route::get('saveNof', 'GradesController@saveNof')->name('saveNof');

        //Route::get('show-matches', 'MatchesController@show-matches')->name('show-matches');

    });
});