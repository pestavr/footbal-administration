<?php

/**
 * All route names are prefixed with 'admin.prints.fylla'.
 */
Route::group([
    'prefix'     => 'fylla',
    'as'         => 'fylla.'
], function () {

    /*
     * User Management
     */
    Route::group([        
        'middleware' => 'access.routeNeedsPermission:4'
    ], function () {
        Route::post('show/{referee}', 'MatchesController@show')->name('show');
       
        Route::get('category', 'MatchSheetsController@show_per_category')->name('category');
        Route::get('date', 'MatchSheetsController@show_per_date')->name('date');
        
       
        Route::get('match/{id}', 'MatchesController@fyllo')->name('match');
       
        Route::get('print-men/{id}', 'MatchesController@print_men')->name('print-men');
        
        //Route::get('show-matches', 'MatchesController@show-matches')->name('show-matches');

    });
});