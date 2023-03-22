<?php

/**
 * All route names are prefixed with 'admin.competition.category'.
 */
Route::group([
    'prefix'     => 'category',
    'as'         => 'category.'
], function () {

    /*
     * User Management
     */
    Route::group([
        'middleware' => 'access.routeNeedsPermission:7',
    ], function () {
        Route::get('index', 'CategoryController@index')->name('index');
        Route::post('get', 'CategoryController@show')->name('get');
        Route::get('insert', 'CategoryController@insert')->name('insert');
        Route::get('deactivated', 'CategoryController@deactivated')->name('deactivated');
        Route::post('get_deactivated', 'CategoryController@show_deactivated')->name('get_deactivated');
        Route::post('do_insert', 'CategoryController@do_insert')->name('do_insert');
        Route::get('edit/{id}', 'CategoryController@edit')->name('edit');
        Route::get('deactivate/{id}', 'CategoryController@deactivate')->name('deactivate');
        Route::get('activate/{id}', 'CategoryController@activate')->name('activate');
        Route::post('update/{id}', 'CategoryController@update')->name('update');
        Route::get('program/{id}', 'CategoryController@program')->name('program');
        Route::get('show/{id}', 'CategoryController@show_modal')->name('show');
        Route::get('getreferee', 'CategoryController@getReferee')->name('getReferee');
        Route::get('makeFlexible/{id}', 'CategoryController@makeFlexible')->name('makeFlexible');
        Route::get('makeNotFlexible/{id}', 'CategoryController@makeNotFlexible')->name('makeNotFlexible');
        

    });
});