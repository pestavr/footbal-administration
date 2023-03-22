<?php

/**
 * All route names are prefixed with 'admin.prints.program'.
 */
Route::group([
    'prefix'     => 'program',
    'as'         => 'program.'
], function () {

    /*
     * User Management
     */
   
    Route::group([        
        'middleware' => 'access.routeNeedsPermission:7'
    ], function () {
        Route::get('index', 'ProgramController@index')->name('index');
        Route::get('date', 'ProgramController@per_date')->name('date');
        Route::post('programMD', 'ProgramController@programMD')->name('programMD');
        Route::post('programDate', 'ProgramController@programDate')->name('programDate');
        
        Route::post('createPerDate', 'ProgramController@createPerDate')->name('createPerDate');
        Route::post('doCreate', 'ProgramController@create')->name('doCreate');
        Route::post('getPerDate', 'ProgramController@getPerDate')->name('getPerDate');
        Route::get('edit/{id}', 'ProgramController@edit')->name('edit');
        Route::post('get_per_md', 'ProgramController@per_md')->name('get_per_md');
        Route::post('print_per_date', 'ProgramController@print_per_date')->name('print_per_date');
       
    });
});