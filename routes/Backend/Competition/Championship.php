<?php

/**
 * All route names are prefixed with 'admin.competion.championship'.
 */
Route::group([
    'prefix'     => 'championship',
    'as'         => 'championship.'
], function () {

    /*
     * User Management
     */
    Route::group([
        'middleware' => 'access.routeNeedsPermission:7',
    ], function () {
        Route::get('index', 'ChampionshipController@index')->name('index');
        Route::post('get', 'ChampionshipController@show')->name('get');
        Route::get('regular', 'ChampionshipController@regular')->name('regular');
        Route::post('saveGroup', 'ChampionshipController@saveGroup')->name('saveGroup');
        Route::get('showPlayOff', 'ChampionshipController@showPlayOff')->name('showPlayOff');
        Route::post('savePlayOffGroup', 'ChampionshipController@savePlayOffGroup')->name('savePlayOffGroup');
        Route::get('program/{id}', 'ChampionshipController@program')->name('program');
        Route::get('delete/{id}', 'ChampionshipController@delete')->name('delete');
        Route::get('show/{id}', 'ChampionshipController@show_modal')->name('show');
        Route::get('edit/{id}', 'ChampionshipController@edit')->name('edit');
        Route::post('update/{id}', 'ChampionshipController@update')->name('update');
        Route::get('draw/{id}', 'ChampionshipController@draw')->name('draw');
        Route::post('saveMatches/{id}', 'ChampionshipController@saveMatches')->name('saveMatches');
        Route::get('deactivate/{id}', 'ChampionshipController@deactivate')->name('deactivate');
        Route::get('activate/{id}', 'ChampionshipController@activate')->name('activate');
        Route::post('showDeactivated', 'ChampionshipController@showDeactivated')->name('showDeactivated');
        Route::get('deactivated', 'ChampionshipController@deactivated')->name('deactivated');
        Route::get('tiebrake/{id}', 'ChampionshipController@tiebrake')->name('tiebrake');
        Route::post('rating/{id}', 'ChampionshipController@rating')->name('rating');
        Route::get('addW/{id}', 'ChampionshipController@addW')->name('addW');
        Route::get('subW/{id}', 'ChampionshipController@subW')->name('subW');
        Route::get('cupMatches', 'ChampionshipController@cupMatches')->name('cupMatches');
        Route::post('cupInputs', 'ChampionshipController@cupInputs')->name('cupInputs');
        Route::post('saveCupMatches/{id}', 'ChampionshipController@saveCupMatches')->name('saveCupMatches');
        Route::get('friendly', 'ChampionshipController@friendly')->name('friendly');
        Route::post('saveFriendlyMatches/{id}', 'ChampionshipController@saveFriendlyMatches')->name('saveFriendlyMatches');
        Route::get('changeTeams/{id}', 'ChampionshipController@changeTeams')->name('changeTeams');
        Route::post('saveTeams/{id}', 'ChampionshipController@saveTeams')->name('saveTeams');
        Route::get('updateRanking/{id}', 'ChampionshipController@updateRanking')->name('updateRanking');
    });
});