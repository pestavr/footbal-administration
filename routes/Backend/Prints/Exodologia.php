<?php

/**
 * All route names are prefixed with 'admin.prints.exodologia'.
 */
Route::group([
    'prefix'     => 'exodologia',
    'as'         => 'exodologia.'
], function () {

    /*
     * User Management
     */
    Route::group([        
        'middleware' => 'access.routeNeedsPermission:4'
    ], function () {
        Route::get('next-exodologia', 'ExodologiaController@my_exodologia')->name('next-exodologia');
        Route::get('my-last-exodologia', 'ExodologiaController@my_last_exodologia')->name('my-last-exodologia');
        Route::post('program', 'ExodologiaController@next_program')->name('program');
        Route::get('print/{id}', 'ExodologiaController@print')->name('print');
        Route::post('printSelected', 'MatchesController@printSelected')->name('printSelected');
        Route::post('print_selected', 'ExodologiaController@print_selected')->name('print_selected');
        Route::post('show/{referee}', 'MatchesController@show')->name('show');
        Route::get('category', 'MatchSheetsController@show_per_category')->name('category');
               
       
        Route::get('match/{id}', 'MatchesController@fyllo')->name('match');
        
       
        Route::get('ref_print/{id}', 'ExodologiaController@ref_print')->name('ref_print');
       
       
        
        //Route::get('show-matches', 'MatchesController@show-matches')->name('show-matches');

    });
    Route::group([        
        'middleware' => 'access.routeNeedsPermission:7'
    ], function () {
        Route::get('create', 'ExodologiaController@show_to_create_per_date')->name('create');
        Route::get('date', 'ExodologiaController@show_per_date')->name('date');
        Route::get('index', 'ExodologiaController@show_per_cat')->name('index');
        Route::get('publish', 'ExodologiaController@show_to_publish_per_date')->name('publish');
        Route::get('printPerDate', 'ExodologiaController@printByDate')->name('printPerDate');
        Route::post('createPerDate', 'ExodologiaController@createPerDate')->name('createPerDate');
        Route::post('doCreate', 'ExodologiaController@create')->name('doCreate');
        Route::post('getPerDate', 'ExodologiaController@getPerDate')->name('getPerDate');
        Route::get('edit/{id}', 'ExodologiaController@edit')->name('edit');
        Route::post('get_per_md', 'ExodologiaController@per_md')->name('get_per_md');
        Route::post('print_per_date', 'ExodologiaController@print_per_date')->name('print_per_date');
        Route::post('doPublish', 'ExodologiaController@publish')->name('doPublish');
        Route::post('update_ex/{id}', 'ExodologiaController@update')->name('update_ex');
        Route::get('delete/{id}', 'ExodologiaController@destroy')->name('delete');
    });
});