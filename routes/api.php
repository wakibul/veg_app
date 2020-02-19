<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/* Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/

Route::post('/customer/register', 'Api\Customer\RegisterController@register');
Route::post('/customer/verify', 'Api\Customer\RegisterController@verify');
Route::post('/customer/login', 'Api\Customer\RegisterController@login');

Route::middleware('auth:api')->group(function(){
    Route::group(['prefix' => 'master'], function () {
        Route::get('/state', 'Api\Master\StateController@index');
        Route::get('/cities', 'Api\Master\CityController@index');
        Route::post('/category', 'Api\Master\CategoryController@index');
        Route::post('/sub-category', 'Api\Master\CategoryController@SubCategory');
        Route::post('/product', 'Api\Master\ProductController@index');
        Route::get('/latest-product', 'Api\Master\ProductController@latest');
        Route::get('/popular-product', 'Api\Master\ProductController@popular');
        Route::get('/pages', 'Api\Master\PagesController@index');
        Route::post('/time-slot', 'Api\Master\TimeSlotController@index');
        Route::post('/pincode', 'Api\Master\PincodeController@index');
        Route::post('/offers', 'Api\Master\CouponController@index');
        Route::post('/offers/apply', 'Api\Master\CouponController@applyCoupon');
        Route::get('/banner', 'Api\Master\BannerController@index');
        Route::post('/search', 'Api\Master\SearchController@index');
        Route::post('/location', 'Api\Master\LocationController@store');
        Route::get('/location/index', 'Api\Master\LocationController@index');
    });
    Route::group(['prefix' => 'customer'], function () {
        Route::get('/cancel-reason', 'Api\Customer\CancellationController@reason');
        Route::post('/cancel', 'Api\Customer\CancellationController@store');
    });

    Route::group(['prefix' => 'cart'], function () {
        Route::post('/store', 'Api\Customer\CartController@store');
        Route::post('/remove', 'Api\Customer\CartController@destroy');
        Route::post('/index', 'Api\Customer\CartController@index');
    });

    Route::group(['prefix' => 'order'], function () {
        Route::post('/store', 'Api\Customer\OrderController@store');
        Route::get('/list', 'Api\Customer\OrderController@index');
    });
});

Route::post('/employee/login', 'Api\Employee\EmployeeController@login');
Route::middleware('auth:employee')->group(function(){
    Route::group(['prefix' => 'employee'], function () {
        Route::get('/user', 'Api\Employee\EmployeeController@user');
        Route::get('/current_orders', 'Api\Employee\EmployeeController@currentOrders');
        Route::post('/otp', 'Api\Employee\EmployeeController@otp');
        Route::post('/close', 'Api\Employee\EmployeeController@close');
        Route::get('/my_orders', 'Api\Employee\EmployeeController@myOrders');
    });
});

