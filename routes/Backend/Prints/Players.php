<?php

/**
 * All route names are prefixed with 'admin.prints.players'.
 */
Route::group([
    'prefix'     => 'players',
    'as'         => 'players.'
], function () {

    /*
     * User Management
     */
   
    Route::group([        
        'middleware' => 'access.routeNeedsPermission:7'
    ], function () {
        Route::get('index', 'PlayersController@index')->name('index');
        Route::post('getPlayers', 'PlayersController@getPlayers')->name('getPlayers');
        Route::get('transfers', 'PlayersController@transfers')->name('transfers');
        Route::post('getTransfers', 'PlayersController@getTransfers')->name('getTransfers');
        Route::get('players', 'PlayersController@players')->name('players');
        Route::post('getPlayers', 'PlayersController@getPlayers')->name('getPlayers');
       
    });
});