<?php

/**
 * All route names are prefixed with 'admin.prints.teams'.
 */
Route::group([
    'prefix'     => 'teams',
    'as'         => 'teams.'
], function () {

    /*
     * User Management
     */
   
    Route::group([        
        'middleware' => 'access.routeNeedsPermission:7'
    ], function () {
        Route::get('index', 'TeamsController@index')->name('index');
        Route::post('getTeams', 'TeamsController@getTeams')->name('getTeams');
        Route::get('program', 'TeamsController@program')->name('program');
        Route::post('getMatches', 'TeamsController@getMatches')->name('getMatches');
        Route::get('players', 'TeamsController@players')->name('players');
        Route::post('getPlayers', 'TeamsController@getPlayers')->name('getPlayers');
       
    });
});