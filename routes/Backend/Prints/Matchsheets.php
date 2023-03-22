<?php

/**
 * All route names are prefixed with 'admin.prints.matchsheets'.
 */
Route::group([
    'prefix'     => 'matchsheets',
    'as'         => 'matchsheets.'
], function () {

    /*
     * User Management
     */
    Route::group([        
        'middleware' => 'access.routeNeedsPermission:4'
    ], function () {
        /*Διακιώματα μόνο για τους Διαιτητές*/
        Route::get('my-match-sheet', 'MatchSheetsController@my_match_sheet')->name('my-match-sheet');
        Route::post('matchsheet', 'MatchSheetsController@matchsheet')->name('matchsheet');
        Route::get('my-last-match-sheet', 'MatchSheetsController@my_last_match_sheet')->name('my-last-match-sheet');

        Route::get('date', 'MatchSheetsController@show_per_date')->name('date');
        Route::get('index', 'MatchSheetsController@index')->name('index');
        Route::post('printSelected', 'MatchSheetsController@printSelected')->name('printSelected');
        Route::get('matchDays', 'MatchSheetsController@show_md')->name('matchDays');
        Route::post('matches_per_md', 'MatchSheetsController@per_md')->name('matches_per_md');
        Route::get('print/{id}', 'MatchSheetsController@print')->name('print');
        Route::get('printMen/{id}', 'MatchSheetsController@printMen')->name('printMen');
        Route::post('matchesPerDate', 'MatchSheetsController@per_date')->name('matchesPerDate');


        Route::post('show/{referee}', 'MatchesController@show')->name('show');
        //Route::get('print/{id}', 'MatchesController@print')->name('print');
        Route::get('category', 'MatchSheetsController@show_per_category')->name('category');
        //Route::get('date', 'MatchSheetsController@show_per_date')->name('date');
        Route::get('next-exodologia', 'ExodologiaController@my_exodologia')->name('next-exodologia');
        Route::post('program', 'ExodologiaController@next_program')->name('program');
        Route::get('match/{id}', 'MatchesController@fyllo')->name('match');
        Route::get('my-last-exodologia', 'ExodologiaController@my_last_exodologia')->name('my-last-exodologia');
       
        Route::get('ref_print/{id}', 'ExodologiaController@ref_print')->name('ref_print');
       
       
        
        //Route::get('show-matches', 'MatchesController@show-matches')->name('show-matches');

    });
    Route::group([        
        'middleware' => 'access.routeNeedsPermission:7'
    ], function () {
        
        /*Διακιώματα μόνο για τον Διαχειριστή*/
        Route::get('publish', 'MatchSheetsController@show_to_publish_per_date')->name('publish');
        Route::get('printPerDate', 'MatchSheetsController@printByDate')->name('printPerDate');
        Route::post('createPerDate', 'MatchSheetsController@createPerDate')->name('createPerDate');
        Route::post('doCreate', 'MatchSheetsController@create')->name('doCreate');
        Route::post('getPerDate', 'MatchSheetsController@getPerDate')->name('getPerDate');
        Route::get('edit/{id}', 'MatchSheetsController@edit')->name('edit');
        Route::post('get_per_md', 'MatchSheetsController@per_md')->name('get_per_md');
        Route::post('print_per_date', 'MatchSheetsController@print_per_date')->name('print_per_date');
        Route::post('doPublish', 'MatchSheetsController@publish')->name('doPublish');
    });
});