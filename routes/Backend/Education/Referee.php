<?php

/**
 * All route names are prefixed with 'admin.kollimata.team'.
 */
Route::group([
    'prefix'     => 'referees',
    'as'         => 'referees.'
], function () {

    /*
     * User Management
     */
    Route::group([
        'middleware' => 'access.routeNeedsPermission:8',
    ], function () {
        Route::get('index', 'RefereeController@index')->name('index');
        Route::get('show/{refereeEducation}', 'RefereeController@show')->name('show');
        Route::get('edit/{refereeEducation}', 'RefereeController@edit')->name('edit');
        Route::get('create', 'RefereeController@create')->name('create');
        Route::post('store', 'RefereeController@store')->name('store');
        Route::post('update/{refereeEducation}', 'RefereeController@update')->name('update');
        Route::get('update/{refereeEducation}', 'RefereeController@update')->name('update');
        Route::get('delete/{refereeEducation}', 'RefereeController@destroy')->name('delete');

        Route::get('answers/index/{educationQuestion}', 'AnswerController@show')->name('answers.index');
        Route::get('answers/update/{educationAnswer}', 'AnswerController@update')->name('answers.update');
    });

    Route::group([
        'middleware' => 'access.routeNeedsPermission:4',
    ], function () {
        Route::get('myeducation/index', 'MyEducationController@index')->name('myeducation.index');
        Route::get('myeducation/show/{refereeEducation}', 'MyEducationController@show')->name('myeducation.show');
        Route::post('myeducation/update/{refereeEducation}', 'MyEducationController@update')->name('myeducation.update');
    });
});