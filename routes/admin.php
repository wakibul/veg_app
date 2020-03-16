<?php

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
    Route::post('/status/{id}', [
        'as' => 'category.status',
        'middleware' => ['admin'],
        'uses' => 'Admin\CategoryController@status',
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
    Route::get('/show/{id}', [
        'as' => 'employee.show',
        'middleware' => ['admin'],
        'uses' => 'Admin\EmployeeController@show',
    ]);

});

Route::group(['prefix' => 'order'], function () {
    Route::get('/order/{order_id}', [
        'as' => 'dashboard.order.accept',
        'middleware' => ['admin'],
        'uses' => 'Admin\OrderController@acceptOrder',
    ]);
    Route::post('/order_reject/{order_id}', [
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
Route::group(['prefix' => 'product'], function () {
    Route::get('/index', [
        'as' => 'product.index',
        'middleware' => ['admin'],
        'uses' => 'Admin\ProductController@index',
    ]);
    Route::get('/create', [
        'as' => 'product.create',
        'middleware' => ['admin'],
        'uses' => 'Admin\ProductController@create',
    ]);

    Route::post('/store', [
        'as' => 'product.store',
        'middleware' => ['admin'],
        'uses' => 'Admin\ProductController@store',
    ]);

    Route::get('/edit/{id}', [
        'as' => 'product.edit',
        'middleware' => ['admin'],
        'uses' => 'Admin\ProductController@edit',
    ]);

    Route::post('/update/{id}', [
        'as' => 'product.update',
        'middleware' => ['admin'],
        'uses' => 'Admin\ProductController@update',
    ]);

    Route::get('/delete/{id}', [
        'as' => 'product.delete',
        'middleware' => ['admin'],
        'uses' => 'Admin\ProductController@destroy',
    ]);
});
Route::group(['prefix' => 'banner'], function () {
    Route::get('/index', [
        'as' => 'banner.index',
        'middleware' => ['admin'],
        'uses' => 'Admin\BannerController@index',
    ]);
    Route::get('/create', [
        'as' => 'banner.create',
        'middleware' => ['admin'],
        'uses' => 'Admin\BannerController@create',
    ]);

    Route::post('/store', [
        'as' => 'banner.store',
        'middleware' => ['admin'],
        'uses' => 'Admin\BannerController@store',
    ]);

    Route::get('/edit/{id}', [
        'as' => 'banner.edit',
        'middleware' => ['admin'],
        'uses' => 'Admin\BannerController@edit',
    ]);

    Route::post('/update/{id}', [
        'as' => 'banner.update',
        'middleware' => ['admin'],
        'uses' => 'Admin\BannerController@update',
    ]);

    Route::get('/delete/{id}', [
        'as' => 'banner.delete',
        'middleware' => ['admin'],
        'uses' => 'Admin\BannerController@destroy',
    ]);
    Route::post('/status/{id}', [
        'as' => 'banner.status',
        'middleware' => ['admin'],
        'uses' => 'Admin\BannerController@status',
    ]);

});
Route::group(['prefix' => 'footer-banner'], function () {
    Route::get('/index', [
        'as' => 'footer-banner.index',
        'middleware' => ['admin'],
        'uses' => 'Admin\AdvertisementController@index',
    ]);
    Route::get('/create', [
        'as' => 'footer-banner.create',
        'middleware' => ['admin'],
        'uses' => 'Admin\AdvertisementController@create',
    ]);

    Route::post('/store', [
        'as' => 'footer-banner.store',
        'middleware' => ['admin'],
        'uses' => 'Admin\AdvertisementController@store',
    ]);

    Route::get('/edit/{id}', [
        'as' => 'footer-banner.edit',
        'middleware' => ['admin'],
        'uses' => 'Admin\AdvertisementController@edit',
    ]);

    Route::post('/update/{id}', [
        'as' => 'footer-banner.update',
        'middleware' => ['admin'],
        'uses' => 'Admin\AdvertisementController@update',
    ]);

    Route::get('/delete/{id}', [
        'as' => 'footer-banner.delete',
        'middleware' => ['admin'],
        'uses' => 'Admin\AdvertisementController@destroy',
    ]);
    Route::post('/status/{id}', [
        'as' => 'footer-banner.status',
        'middleware' => ['admin'],
        'uses' => 'Admin\AdvertisementController@status',
    ]);

});

Route::group(['prefix' => 'coupon'], function () {
    Route::get('/index', [
        'as' => 'coupon.index',
        'middleware' => ['admin'],
        'uses' => 'Admin\CouponController@index',
    ]);
    Route::get('/create', [
        'as' => 'coupon.create',
        'middleware' => ['admin'],
        'uses' => 'Admin\CouponController@create',
    ]);

    Route::post('/store', [
        'as' => 'coupon.store',
        'middleware' => ['admin'],
        'uses' => 'Admin\CouponController@store',
    ]);

    Route::get('/edit/{id}', [
        'as' => 'coupon.edit',
        'middleware' => ['admin'],
        'uses' => 'Admin\CouponController@edit',
    ]);

    Route::post('/update/{id}', [
        'as' => 'coupon.update',
        'middleware' => ['admin'],
        'uses' => 'Admin\CouponController@update',
    ]);
    Route::post('/status/{id}', [
        'as' => 'coupon.status',
        'middleware' => ['admin'],
        'uses' => 'Admin\CouponController@status',
    ]);

    Route::get('/delete/{id}', [
        'as' => 'coupon.delete',
        'middleware' => ['admin'],
        'uses' => 'Admin\CouponController@destroy',
    ]);
});
Route::group(['prefix' => 'settlement'], function () {
    Route::get('/index', [
        'as' => 'settlement.index',
        'middleware' => ['admin'],
        'uses' => 'Admin\settlementController@index',
    ]);
    Route::post('/store', [
        'as' => 'settlement.store',
        'middleware' => ['admin'],
        'uses' => 'Admin\settlementController@store',
    ]);

});
Route::group(['prefix' => 'report'], function () {
    Route::get('/index', [
        'as' => 'report.index',
        'middleware' => ['admin'],
        'uses' => 'Admin\reportController@index',
    ]);

});
Route::group(['prefix' => 'customer'], function () {
    Route::get('/index', [
        'as' => 'customer.index',
        'middleware' => ['admin'],
        'uses' => 'Admin\CustomerController@index',
    ]);
    Route::post('/notification', [
        'as' => 'customer.notification.store',
        'middleware' => ['admin'],
        'uses' => 'Admin\CustomerController@notification',
    ]);
    Route::get('/customer/view/{customer_id}',[
        'as'=>'customer.view',
        'middleware' => ['admin'],
        'uses' => 'Admin\CustomerController@view',
    ]);

});
Route::group(['prefix' => 'changePasword'], function () {
    Route::get('/index', [
        'as' => 'changePassword',
        'middleware' => ['admin'],
        'uses' => 'Admin\ResetPasswordController@index',
    ]);
    Route::post('/editPassword', [
    'as' => 'editPassword',
    'middleware' => ['admin'],
    'uses' => 'Admin\ResetPasswordController@update',
]);

});
