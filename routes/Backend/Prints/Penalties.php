<?php

/**
 * All route names are prefixed with 'admin.prints.penalties'.
 */
Route::group([
    'prefix'     => 'penalties',
    'as'         => 'penalties.'
], function () {

    /*
     * User Management
     */
   
    Route::group([        
        'middleware' => 'access.routeNeedsPermission:7'
    ], function () {
        Route::get('teamsIndex', 'PenaltiesController@teamsIndex')->name('teamsIndex');
        Route::post('getTeamsPenalties', 'PenaltiesController@getTeamsPenalties')->name('getTeamsPenalties');
        Route::get('playersIndex', 'PenaltiesController@playersIndex')->name('playersIndex');
        Route::post('getPlayersPenalties', 'PenaltiesController@getPlayersPenalties')->name('getPlayersPenalties');
        Route::get('officialsIndex', 'PenaltiesController@officialsIndex')->name('officialsIndex');
        Route::post('getOfficialsPenalties', 'PenaltiesController@getOfficialsPenalties')->name('getOfficialsPenalties');
        Route::get('allIndex', 'PenaltiesController@allIndex')->name('allIndex');
        Route::post('getAllPenalties', 'PenaltiesController@getAllPenalties')->name('getAllPenalties');
    });
});