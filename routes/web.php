<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Client'], function () {
    Route::get('/', 'AuthController@showFormLogin')->name('login');
    Route::get('login', 'AuthController@showFormLogin')->name('login');
    Route::post('login', 'AuthController@login');
    Route::get('register', 'AuthController@showFormRegister')->name('register');
    Route::post('register', 'AuthController@register');

    Route::group(['middleware' => 'auth'], function () {
        Route::get('dashboard', 'DashboardController@index')->name('dashboard');
        Route::get('logout', 'AuthController@logout')->name('logout');


        Route::resource('users', 'UserController');
        Route::resource('categories', 'CategoryController')->except([ 'edit', 'create']);
        Route::get('categories/all/data', 'CategoryController@allCategory');

        /** Products */
        Route::group(['prefix' => 'products'], function () {
            Route::get('/', 'ProductController@index')->name('products.index');
            Route::get('/lists', 'ProductController@lists')->name('products.lists');
            Route::get('/create', 'ProductController@create');
            Route::get('/{product}', 'ProductController@show')->name('products.show');
            Route::post('/', 'ProductController@store')->name('products.store');
            Route::put('/{product}', 'ProductController@update')->name('products.update');
            Route::delete('/{product}', 'ProductController@destroy')->name('products.destroy');
        });

        /** Product Classification */
        Route::resource('classification_products', 'ProductClassificationController')->except([ 'edit', 'create']);

        /** Product Detail */
        Route::resource('details_product', 'ProductDetailController');

        /** Classifications */
        Route::get('classifications/all', 'ClassificationController@getClassifications');



        Route::group(['prefix' => 'datatables'], function () {
            Route::get('categories', 'MasterDatatableController@categoriesRecord');
            Route::get('products', 'MasterDatatableController@productsRecord');
            Route::get('classification_products', 'MasterDatatableController@prodcutClassificationRecord');
        });
    });
});
