<?php

/**
 * All route names are prefixed with 'admin.live.live'.
 */
Route::group([
    'prefix'     => 'live',
    'as'         => 'live.'
], function () {

    /*
     * User Management
     */
    Route::group([
        'middleware' => 'access.routeNeedsPermission:5',
    ], function () {
       Route::get('match/{id}', 'LiveController@match')->name('match');
       Route::get('matchObserver/{id}', 'LiveController@matchObserver')->name('matchObserver');
       Route::get('start/{id}', 'LiveController@start')->name('start');
       Route::get('startB/{id}', 'LiveController@startB')->name('startB');
       Route::get('endA/{id}', 'LiveController@endA')->name('endA');
       Route::get('end/{id}', 'LiveController@end')->name('end');
       Route::post('getLiveMatch', 'LiveController@getLiveMatch')->name('getLiveMatch');
       Route::get('delete/{id}', 'LiveController@delete')->name('delete');
       Route::post('insertEvent/{id}', 'LiveController@insertEvent')->name('insertEvent');
       Route::get('goal/{id}/{team}', 'LiveController@goal')->name('goal');
       Route::get('red/{id}/{team}', 'LiveController@red')->name('red');
       Route::get('yellow/{id}/{team}', 'LiveController@yellow')->name('yellow');
       Route::get('owngoal/{id}/{team}', 'LiveController@owngoal')->name('owngoal');
    });

        Route::group([
        'middleware' => 'access.routeNeedsPermission:7',
    ], function () {
        Route::get('index', 'LiveController@index')->name('index');
        Route::post('get', 'LiveController@show')->name('get');
        Route::post('getMD', 'LiveController@ProgramMD')->name('getMD');
        Route::post('getDate', 'LiveController@ProgramDate')->name('getDate');
        Route::get('date', 'LiveController@per_date')->name('date');
        
    });
});