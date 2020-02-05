<?php

Route::get('/home', function () {
    $users[] = Auth::user();
    $users[] = Auth::guard()->user();
    $users[] = Auth::guard('admin')->user();

    //dd($users);

    return view('admin.home');
})->name('home');

Route::group(['prefix' => 'category'], function () {
	Route::get('/index', [
		'as' => 'category.index',
		'middleware' => ['admin'],
		'uses' => 'Admin\CategoryController@index'
    ]);

    Route::post('/store', [
        'as' => 'category.store',
        'middleware' => ['admin'],
        'uses' => 'Admin\CategoryController@store'
    ]);

    Route::get('/edit/{id}', [
        'as' => 'category.edit',
        'middleware' => ['admin'],
        'uses' => 'Admin\CategoryController@edit'
    ]);


    Route::post('/update/{id}', [
        'as' => 'category.update',
        'middleware' => ['admin'],
        'uses' => 'Admin\CategoryController@update'
    ]);

    Route::get('/delete/{id}', [
        'as' => 'category.delete',
        'middleware' => ['admin'],
        'uses' => 'Admin\CategoryController@destroy'
    ]);
});

