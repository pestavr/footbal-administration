<?php

/**
 * All route names are prefixed with 'admin.prints.competition'.
 */
Route::group([
    'prefix'     => 'competition',
    'as'         => 'competition.'
], function () {

    /*
     * User Management
     */
   
    Route::group([        
        'middleware' => 'access.routeNeedsPermission:7'
    ], function () {
        Route::get('index', 'CompetitionController@index')->name('index');
        Route::get('ranking', 'CompetitionController@ranking')->name('ranking');
        Route::post('getTeams', 'CompetitionController@getTeams')->name('getTeams');
        Route::get('ranking', 'CompetitionController@ranking')->name('ranking');
        Route::post('getRanking', 'CompetitionController@getRanking')->name('getRanking');
        Route::get('sym', 'CompetitionController@sym')->name('sym');
        Route::post('getSym', 'CompetitionController@getSym')->name('getSym');
        Route::get('scorer', 'CompetitionController@scorer')->name('scorer');
        Route::post('getScorer', 'CompetitionController@getScorer')->name('getScorer');
       
    });
});