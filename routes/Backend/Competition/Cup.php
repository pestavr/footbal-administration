<?php

/**
 * All route names are prefixed with 'admin.competion.cup'.
 */
Route::group([
    'prefix'     => 'cup',
    'as'         => 'cup.'
], function () {

    /*
     * User Management
     */
    Route::group([
        'middleware' => 'access.routeNeedsPermission:7',
    ], function () {
        Route::get('index', 'CupController@index')->name('index');
        Route::post('get', 'CupController@show')->name('get');
        Route::get('regular', 'CupController@regular')->name('regular');
        Route::post('saveGroup', 'CupController@saveGroup')->name('saveGroup');
        Route::get('showPlayOff', 'CupController@showPlayOff')->name('showPlayOff');
        Route::post('savePlayOffGroup', 'CupController@savePlayOffGroup')->name('savePlayOffGroup');
        Route::get('program/{id}', 'CupController@program')->name('program');
        Route::get('delete/{id}', 'CupController@delete')->name('delete');
        Route::get('show/{id}', 'CupController@show_modal')->name('show');
        Route::get('edit/{id}', 'CupController@edit')->name('edit');
        Route::post('update/{id}', 'CupController@update')->name('update');
        Route::get('draw/{id}', 'CupController@draw')->name('draw');
        Route::post('saveMatches/{id}', 'CupController@saveMatches')->name('saveMatches');
        Route::get('deactivate/{id}', 'CupController@deactivate')->name('deactivate');
        Route::get('activate/{id}', 'CupController@activate')->name('activate');
        Route::post('showDeactivated', 'CupController@showDeactivated')->name('showDeactivated');
        Route::get('deactivated', 'CupController@deactivated')->name('deactivated');
        Route::get('tiebrake/{id}', 'CupController@tiebrake')->name('tiebrake');
        Route::post('rating/{id}', 'CupController@rating')->name('rating');
        Route::get('addW/{id}', 'CupController@addW')->name('addW');
        Route::get('subW/{id}', 'CupController@subW')->name('subW');
        Route::get('cupMatches', 'CupController@cupMatches')->name('cupMatches');
        Route::post('cupInputs', 'CupController@cupInputs')->name('cupInputs');
        Route::post('saveCupMatches/{id}', 'CupController@saveCupMatches')->name('saveCupMatches');
        Route::get('changeTeams/{id}', 'CupController@changeTeams')->name('changeTeams');
        Route::post('saveTeams/{id}', 'CupController@saveTeams')->name('saveTeams');

    });
});