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
            Route::get('/edit/{product}', 'ProductController@edit');
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
        Route::get('/list/details_product', 'ProductDetailController@getListDetail');

        /** Classifications */
        Route::get('classifications/all', 'ClassificationController@getClassifications');


        Route::group(['prefix' => 'orders'], function () {
            Route::get('/preview/{id}', 'OrderController@previewOrder');
            Route::get('/cart/preview', 'OrderController@previewCart');
            Route::post('/add_to_cart', 'OrderController@addToCart');
            Route::get('/tester', 'OrderController@tester');
            Route::get('/remove/{id}/cart/{code}', 'OrderController@removeCart');
        });

        Route::group(['prefix' => 'invoices'], function () {
            Route::get('/', 'InvoiceController@viewInvoice');
            Route::get('/view/payment', 'InvoiceController@viewPayment');
            Route::post('/store/payment', 'InvoiceController@storePayment');
        });


        Route::group(['prefix' => 'datatables'], function () {
            Route::get('categories', 'MasterDatatableController@categoriesRecord');
            Route::get('products', 'MasterDatatableController@productsRecord');
            Route::get('classification_products', 'MasterDatatableController@productClassificationRecord');

            Route::get('product_details', 'MasterDatatableController@productDetailsRecord');
        });
    });
});
