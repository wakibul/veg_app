<?php

use App\Models\Employee;
use App\Models\Order;
Route::get('/home', [
    'as' => 'home',
    'uses' => 'Admin\DashboardController@index',
]);



Route::group(['prefix' => 'category'], function () {
    Route::get('/index', [
        'as' => 'category.index',
        'middleware' => ['admin'],
        'uses' => 'Admin\CategoryController@index',
    ]);

    Route::post('/store', [
        'as' => 'category.store',
        'middleware' => ['admin'],
        'uses' => 'Admin\CategoryController@store',
    ]);

    Route::get('/edit/{id}', [
        'as' => 'category.edit',
        'middleware' => ['admin'],
        'uses' => 'Admin\CategoryController@edit',
    ]);

    Route::post('/update/{id}', [
        'as' => 'category.update',
        'middleware' => ['admin'],
        'uses' => 'Admin\CategoryController@update',
    ]);

    Route::get('/delete/{id}', [
        'as' => 'category.delete',
        'middleware' => ['admin'],
        'uses' => 'Admin\CategoryController@destroy',
    ]);
});
Route::group(['prefix' => 'unit'], function () {
    Route::get('/index', [
        'as' => 'unit.index',
        'middleware' => ['admin'],
        'uses' => 'Admin\UnitController@index',
    ]);

    Route::post('/store', [
        'as' => 'unit.store',
        'middleware' => ['admin'],
        'uses' => 'Admin\UnitController@store',
    ]);

    Route::get('/edit/{id}', [
        'as' => 'unit.edit',
        'middleware' => ['admin'],
        'uses' => 'Admin\UnitController@edit',
    ]);

    Route::post('/update/{id}', [
        'as' => 'unit.update',
        'middleware' => ['admin'],
        'uses' => 'Admin\UnitController@update',
    ]);

    Route::get('/delete/{id}', [
        'as' => 'unit.delete',
        'middleware' => ['admin'],
        'uses' => 'Admin\UnitController@destroy',
    ]);
});
Route::group(['prefix' => 'employee'], function () {
    Route::get('/index', [
        'as' => 'employee.index',
        'middleware' => ['admin'],
        'uses' => 'Admin\EmployeeController@index',
    ]);

    Route::post('/store', [
        'as' => 'employee.store',
        'middleware' => ['admin'],
        'uses' => 'Admin\EmployeeController@store',
    ]);

    Route::get('/edit/{id}', [
        'as' => 'employee.edit',
        'middleware' => ['admin'],
        'uses' => 'Admin\EmployeeController@edit',
    ]);

    Route::post('/update/{id}', [
        'as' => 'employee.update',
        'middleware' => ['admin'],
        'uses' => 'Admin\EmployeeController@update',
    ]);

    Route::get('/delete/{id}', [
        'as' => 'employee.delete',
        'middleware' => ['admin'],
        'uses' => 'Admin\EmployeeController@destroy',
    ]);

});

Route::group(['prefix' => 'order'], function () {
    Route::get('/order/{order_id}', [
        'as' => 'dashboard.order.accept',
        'middleware' => ['admin'],
        'uses' => 'Admin\OrderController@acceptOrder',
    ]);
    Route::get('/order_reject/{order_id}', [
        'as' => 'dashboard.order.reject',
        'middleware' => ['admin'],
        'uses' => 'Admin\OrderController@rejectOrder',
    ]);
    Route::get('/order_close/{order_id}', [
        'as' => 'dashboard.order.close',
        'middleware' => ['admin'],
        'uses' => 'Admin\OrderController@closeOrder',
    ]);
    Route::post('/assign_employee', [
        'as' => 'assign_employee.store',
        'middleware' => ['admin'],
        'uses' => 'Admin\OrderController@assignEmployee',
    ]);

});
