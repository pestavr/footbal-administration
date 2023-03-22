<?php

/**
 * All route names are prefixed with 'admin.prints.doctor'.
 */
Route::group([
    'prefix'     => 'doctor',
    'as'         => 'doctor.'
], function () {

    /*
     * User Management
     */
    Route::group([        
        'middleware' => 'access.routeNeedsPermission:7'
    ], function () {
        Route::get('index', 'doctorController@index')->name('index');
        Route::post('show', 'doctorController@show')->name('show');
        Route::get('orismoi', 'doctorController@orismoi')->name('orismoi');
        Route::post('orismoi', 'doctorController@getOrismoi')->name('orismoi');
        
    });
});