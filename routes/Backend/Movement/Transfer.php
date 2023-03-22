<?php

/**
 * All route names are prefixed with 'admin.move.transfer'.
 */
Route::group([
    'prefix'     => 'transfer',
    'as'         => 'transfer.'
], function () {

    /*
     * User Management
     */
    Route::group([
        'middleware' => 'access.routeNeedsPermission:7',
    ], function () {
        Route::get('index', 'TransferController@index')->name('index');
        Route::post('get', 'TransferController@show')->name('get');
        Route::get('insert', 'TransferController@insert')->name('insert');
        Route::get('show/{id}', 'TransferController@show_modal')->name('show');
        Route::post('do_insert', 'TransferController@do_insert')->name('do_insert');
        Route::post('do_st_insert', 'TransferController@do_st_insert')->name('do_st_insert');
        Route::get('edit/{id}', 'TransferController@edit')->name('edit');
        Route::get('delete/{id}', 'TransferController@destroy')->name('delete');
        Route::get('activate/{id}', 'TransferController@activate')->name('activate');
        Route::post('update/{id}', 'TransferController@update')->name('update');
        Route::get('program/{id}', 'TransferController@program')->name('program');
        Route::post('getProgram/{id}', 'TransferController@get_program')->name('getProgram');
        Route::get('transfer/{id}', 'TransferController@transferToTeam')->name('transfer');
        Route::get('doΤransfer/{id}/{team}', 'TransferController@doTransferToTeam')->name('doΤransfer');
        //Route::get('show-matches', 'MatchesController@show-matches')->name('show-matches');

    });
});