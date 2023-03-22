<?php

/**
 * All route names are prefixed with 'admin.program.match'.
 */
Route::group([
    'prefix'     => 'match',
    'as'         => 'match.'
], function () {

    /*
     * User Management
     */
    Route::group([
        'middleware' => 'access.routeNeedsPermission:7',
    ], function () {
         Route::get('insert/{id}', 'MatchController@insert')->name('insert');
         Route::get('addPlayer/{id}', 'MatchController@addPlayer')->name('addPlayer');
         Route::post('saveStats/{id}', 'MatchController@saveStats')->name('saveStats');
         Route::get('delete/{id}', 'MatchController@delete')->name('delete');
         Route::get('edit/{id}', 'MatchController@edit')->name('edit');
         Route::post('saveEdit/{id}', 'MatchController@saveEdit')->name('saveEdit');
        
    });
});