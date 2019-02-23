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

// ==================== Auth route
Route::group([

    'middleware' => ['api'],
    'prefix' => 'auth'

], function () {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('signup', 'AuthController@signup');
    Route::Get('me', 'AuthController@me');
    Route::Post('activation/send', 'AuthController@sendAcCode');
    Route::Post('activation/check', 'AuthController@checkActivationCode');


});
// ==================== Media Route
Route::resource('media', 'MediaController');
// ==================== Product Route
Route::resource('product', 'ProductController');
Route::Get('productbycat', 'ProductController@getProductByCat');
Route::Get('discounted/products', 'ProductController@discountedProduct');
// ==================== Product Category Route
Route::resource('products/category', 'ProductcatController');
// ==================== Slider route
Route::resource('slider', 'SliderController');
// ==================== ContentCat route
Route::resource('content/category', 'ContentcatController');
// ==================== Content route
Route::resource('contents', 'ContentController');
Route::Get('contentbycat', 'ContentController@getContentByCat');
// ==================== Activation code route
Route::resource('activationcode', 'ActivationCodeController');
