<?php

/**
 * All route names are prefixed with 'admin.prints.refObserver'.
 */
Route::group([
    'prefix'     => 'refObserver',
    'as'         => 'refObserver.'
], function () {

    /*
     * User Management
     */
    Route::group([        
        'middleware' => 'access.routeNeedsPermission:3'
    ], function () {
        Route::get('index', 'refObserverController@index')->name('index');
        Route::post('show', 'refObserverController@show')->name('show');
        Route::get('orismoi', 'refObserverController@orismoi')->name('orismoi');
        Route::post('orismoi', 'refObserverController@getOrismoi')->name('orismoi');
        
    });
});