<?php

/**
 * All route names are prefixed with 'admin.matches'.
 */
Route::group([
    'prefix'     => 'matches',
    'as'         => 'matches.'
], function () {

    /*
     * User Management
     */
    Route::group([
        'middleware' => 'access.routeNeedsPermission:3'
    ], function () {
        Route::post('get/{id}', 'MatchesController@referee')->name('get');
        
        
        Route::post('print_selected', 'MatchesController@print_selected')->name('print_selected');
        
        
        
        
         
        
        
        
        
        
        
        Route::post('get_exodologia_per_md', 'ExodologiaController@per_md')->name('get_exodologia_per_md');
    });
});