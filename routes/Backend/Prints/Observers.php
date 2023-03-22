<?php

/**
 * All route names are prefixed with 'admin.prints.observer'.
 */
Route::group([
    'prefix'     => 'observer',
    'as'         => 'observer.'
], function () {

    /*
     * User Management
     */
    Route::group([        
        'middleware' => 'access.routeNeedsPermission:7'
    ], function () {
        Route::get('index', 'ObserverController@index')->name('index');
        Route::post('show', 'ObserverController@show')->name('show');
        Route::get('orismoi', 'ObserverController@orismoi')->name('orismoi');
        Route::post('orismoi', 'ObserverController@getOrismoi')->name('orismoi');
        
    });
});