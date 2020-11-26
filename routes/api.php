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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', 'Api\Auth\AuthController@login');
    Route::post('signup', 'Api\Auth\AuthController@signup');
  
    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('logout', 'Api\Auth\AuthController@logout');
        Route::get('user', 'Api\Auth\AuthController@user');

        Route::apiResource('users', 'Api\UserController');
    });



});


Route::apiResource('brand', 'Api\BrandController');
Route::apiResource('category', 'Api\CategoryController');
Route::apiResource('product', 'Api\ProductController');
Route::apiResource('order', 'Api\OrderController');
Route::apiResource('send-message-contact', 'Api\MessageController');
Route::apiResource('pay-methods', 'Api\PaymentMethodController');
Route::apiResource('notification-cobro', 'Api\NotificationMercadoPagoController');
Route::apiResource('status', 'Api\StatusController');
Route::apiResource('carousel', 'Api\CarouselController');
Route::apiResource('image', 'Api\ImageController');



Route::get('brand-by-slug/{slug}', 'Api\BrandController@brand_by_slug');
Route::get('category-by-slug/{slug}', 'Api\CategoryController@bySlug');
Route::get('product-by-slug/{slug}', 'Api\ProductController@bySlug');
Route::get('product-by-category/{category_id}', 'Api\ProductController@byCategoryID');
Route::get('product-by-brand/{brand_id}', 'Api\ProductController@byBrandID');
Route::get('search', 'Api\SearchController@search');
Route::get('search-paginate/{criterio}', 'Api\SearchController@search_paginate');
Route::get('active-carousel', 'Api\CarouselController@active');
Route::get('relacionar', 'Api\CategoryController@relacionar');


Route::get('export_user', 'Api\UserController@export_user_excel');
Route::get('products-faceboock', 'Api\ProductController@exportFaceboock');
Route::post('social-auth', 'Api\Auth\SocialAuthController@loginSocial');


// Route::post('registro_cliente_cobrosya', 'Api\Cobrosya\EnvioPagosController@registrar_cliente');
// Route::post('crear_talon_cobrosya', 'Api\Cobrosya\EnvioPagosController@crear_talon');
// Route::post('user_tarjetas', 'Api\Cobrosya\EnvioPagosController@user_tarjetas');
// Route::post('navega-a-cobro', 'Api\Cobrosya\EnvioPagosController@navega_a_cobro');
// Route::post('firma-cobrosya', 'Api\Cobrosya\EnvioPagosController@firma');


Route::group([    
    'namespace' => 'Api\Auth',    
    'middleware' => 'api',    
    'prefix' => 'password'
], function () {    
    Route::post('create', 'PasswordResetController@create');
    Route::get('find/{token}', 'PasswordResetController@find');
    Route::post('reset', 'PasswordResetController@reset');
});
// Route::get('import', 'Api\ImportImagesController@import');