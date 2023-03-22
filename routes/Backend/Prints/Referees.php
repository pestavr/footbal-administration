<?php

/**
 * All route names are prefixed with 'admin.prints.referee'.
 */
Route::group([
    'prefix'     => 'referee',
    'as'         => 'referee.'
], function () {

    /*
     * User Management
     */
    Route::group([        
        'middleware' => 'access.routeNeedsPermission:4'
    ], function () {
        Route::get('date', 'MatchsheetsController@show_per_date')->name('date');
        Route::get('index', 'MatchsheetsController@index')->name('index');
        Route::post('printSelected', 'MatchsheetsController@printSelected')->name('printSelected');
        Route::get('matchDays', 'MatchsheetsController@show_md')->name('matchDays');
        Route::post('matches_per_md', 'MatchsheetsController@per_md')->name('matches_per_md');
        Route::get('print/{id}', 'MatchSheetsController@print')->name('print');
        Route::get('printMen/{id}', 'MatchSheetsController@printMen')->name('printMen');
        Route::post('matchesPerDate', 'MatchSheetsController@per_date')->name('matchesPerDate');
        
        
        Route::post('show/{referee}', 'MatchesController@show')->name('show');
        Route::get('category', 'MatchSheetsController@show_per_category')->name('category');
        Route::get('next-exodologia', 'ExodologiaController@my_exodologia')->name('next-exodologia');
        Route::post('program', 'ExodologiaController@next_program')->name('program');
        Route::get('match/{id}', 'MatchesController@fyllo')->name('match');
        Route::get('my-last-exodologia', 'ExodologiaController@my_last_exodologia')->name('my-last-exodologia');
       
        Route::get('ref_print/{id}', 'ExodologiaController@ref_print')->name('ref_print');
       
       

    });
    Route::group([        
        'middleware' => 'access.routeNeedsPermission:3'
    ], function () {
        Route::get('index', 'RefereeController@index')->name('index');
        Route::post('show', 'RefereeController@show')->name('show');
        Route::get('orismoi', 'RefereeController@orismoi')->name('orismoi');
        Route::post('orismoi', 'RefereeController@getOrismoi')->name('orismoi');
        
    });
});