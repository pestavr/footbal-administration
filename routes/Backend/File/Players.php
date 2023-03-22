<?php

/**
 * All route names are prefixed with 'admin.file.players'.
 */
Route::group([
    'prefix'     => 'players',
    'as'         => 'players.'
], function () {

    /*
     * User Management
     */
    Route::group([
        'middleware' => 'access.routeNeedsPermission:7',
    ], function () {
        Route::get('index', 'PlayersController@index')->name('index');
        Route::post('get', 'PlayersController@show')->name('get');
        Route::get('insert', 'PlayersController@insert')->name('insert');
        Route::get('deactivated', 'PlayersController@deactivated')->name('deactivated');
        Route::post('get_deactivated', 'PlayersController@show_deactivated')->name('get_deactivated');
        Route::post('do_insert', 'PlayersController@do_insert')->name('do_insert');
        Route::post('do_st_insert', 'PlayersController@do_st_insert')->name('do_st_insert');
        Route::get('edit/{id}', 'PlayersController@edit')->name('edit');
        Route::get('deactivate/{id}', 'PlayersController@deactivate')->name('deactivate');
        Route::get('activate/{id}', 'PlayersController@activate')->name('activate');
        Route::post('update/{id}', 'PlayersController@update')->name('update');
        Route::get('program/{id}', 'PlayersController@program')->name('program');
        Route::get('show/{id}', 'PlayersController@show_modal')->name('show');
        Route::get('team/{id}', 'PlayersController@per_team')->name('team');
        Route::post('get_per_team/{id}', 'PlayersController@show_per_team')->name('get_per_team');
        Route::get('getPlayer', 'PlayersController@getPlayer')->name('getPlayer');
        Route::get('insertTeamPlayer/{id}', 'PlayersController@insertTeamPlayer')->name('insertTeamPlayer');
        Route::post('searchPlayer/{id}', 'PlayersController@searchPlayer')->name('searchPlayer');
        Route::get('uploadPlayersFromFile', 'PlayersController@uploadPlayersFromFile')->name('uploadPlayersFromFile');
        Route::post('doUploadPlayersFromFile', 'PlayersController@doUploadPlayersFromFile')->name('doUploadPlayersFromFile');
        //Route::get('show-matches', 'MatchesController@show-matches')->name('show-matches');

    });
});