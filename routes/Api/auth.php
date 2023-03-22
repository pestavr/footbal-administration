<?php

/**
 * Frontend Controllers
 * All route names are prefixed with 'api.'.
 */

Route::post('login', 'ApiLoginController@login')->name('login');
Route::get('test', 'ApiLoginController@test')->name('test');
Route::get('rankings/{group}', 'ChampionshipController@rankingJson')->name('rankings');
Route::get('competitions', 'ChampionshipController@competitions')->name('competitions');
Route::get('program/{group}', 'ChampionshipController@getProgram')->name('program');

/*
 * These frontend controllers require the user to be logged in
 * All route names are prefixed with 'frontend.'
 */
Route::group(['middleware' => 'auth:api'], function () {
    Route::post('matches', 'ApiProgramController@getMatches')->name('matches');
    Route::get('allMatches', 'ApiProgramController@getAllMatches')->name('allMatches');
    Route::get('matchDetails/{id}', 'ApiMatchController@getMatchDetails')->name('matchDetails');
    Route::get('teamRoster/{id}', 'ApiMatchController@getTeamRoster')->name('teamRoster');
});


