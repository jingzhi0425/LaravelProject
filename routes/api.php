<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'system', 'as' => 'api.admin.'], function () {
    Route::group(['namespace' => 'Api\V1\Admin', 'middleware' => ['auth:api']], function () {
        Route::POST('image-store', 'ImageApiController@StoreImage');
    });
});

Route::group(['prefix' => 'admin', 'as' => 'api.admin.', 'namespace' => 'Api\V1\Admin'], function () {
    Route::group(['middleware' => ['auth:api']], function () {
        Route::GET('/user', function (Request $request) {
            return $request->user();
        });

        // Permissions
        Route::apiResource('permissions', 'PermissionsApiController', ['except' => ['store', 'update', 'destroy']]);

        // Roles
        Route::apiResource('roles', 'RolesApiController', ['except' => ['destroy']]);

        // Users
        Route::apiResource('users', 'UsersApiController');

        // User Login Log
        Route::apiResource('user-login-logs', 'UserLoginLogApiController');

        // Language
        Route::apiResource('languages', 'LanguageApiController');

        // Image
        Route::POST('images/media', 'ImageApiController@storeMedia')->name('images.storeMedia');
        Route::POST('images/user-ic-receipt', 'ImageApiController@store_user_ic_request');
        Route::POST('images/user-avater-receipt', 'ImageApiController@store_user_avater_request');
        Route::apiResource('images', 'ImageApiController');

        // Notice Board
        Route::POST('notice-boards/media', 'NoticeBoardApiController@storeMedia')->name('notice-boards.storeMedia');
        Route::apiResource('notice-boards', 'NoticeBoardApiController');
        Route::GET('get-banner/{type}', 'NoticeBoardApiController@get_banner');

        // Countries
        Route::apiResource('countries', 'CountriesApiController');

        // Product-category
        Route::apiResource('product-category', 'ProductCategoryApiController');
        Route::PUT('update-product-category/{uid}', 'ProductCategoryApiController@update_product_category');
        Route::DELETE('delete-product-category/{uid}', 'ProductCategoryApiController@delete_product_category');
        Route::GET('show-product-category/{uid}', 'ProductCategoryApiController@show_product_category');
        Route::POST('active-product-category', 'ProductCategoryApiController@active_product_category');

        // Product
        Route::apiResource('product', 'ProductApiController');
        Route::PUT('update-product/{uid}', 'ProductApiController@update_product');
        Route::DELETE('delete-product/{uid}', 'ProductApiController@delete_product');
        Route::GET('show-product/{uid}', 'ProductApiController@show_product');
        Route::POST('active-product', 'ProductApiController@active_product');
    });
});

Route::group(['prefix' => 'users', 'as' => 'api.users.', 'namespace' => 'Api\V1\Users'], function () {

    // Client Register and Login
    Route::POST('user-register', 'UsersApiController@register')->middleware(['data.decrypt']);
    Route::POST('user-login', 'UsersApiController@login')->middleware(['data.encrypt']);

    Route::group(['middleware' => ['auth:api', 'scope:view-user']], function () {
        Route::GET('/user', function (Request $request) {
            return $request->user();
        });
    });
});
