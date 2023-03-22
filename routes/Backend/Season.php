<?php

/**
 * All route names are prefixed with 'admin.season'.
 */
Route::group([
    'prefix'     => 'season',
    'as'         => 'season.'
], function () {

    /*
     * User Management
     */
    Route::group([
        'middleware' => 'access.routeNeedsPermission:4'
    ], function () {
        Route::get('set/{id}', 'SeasonController@set')->name('set');
        

    });
    Route::group([
        'middleware' => 'access.routeNeedsPermission:3'
    ], function () {
        
        Route::get('create', 'SeasonController@create')->name('create');
        Route::post('insert', 'SeasonController@insert')->name('insert');
        

    });
});