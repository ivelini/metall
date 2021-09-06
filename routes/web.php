<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminPanel\Catalog\CatalogImportPriceController;
use App\Http\Controllers\AdminPanel\Catalog\CatalogOtvodyContoller;
use App\Http\Controllers\AdminPanel\Catalog\CatalogPerehodyController;
use App\Http\Controllers\AdminPanel\Catalog\CatalogTroinikiController;
use App\Http\Controllers\AdminPanel\Catalog\CatalogDnishaController;
use \App\Http\Controllers\AdminPanel\Catalog\CatalogProductCategoryController;
use \App\Http\Controllers\AdminPanel\Content\ContentRecordCategoryController;
use \App\Http\Controllers\AdminPanel\Content\ContentRecordController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
require __DIR__.'/auth.php';

Route::get('/', function () {
    return redirect('admin-panel/dashboard');
});

Route::group(['prefix' => 'admin-panel', 'middleware' => 'auth'], function () {
    Route::view('/dashboard', 'admin_panel.dashboard')->name('dashboard');

    Route::group(['prefix' => 'catalog'], function () {

        Route::get('price-import', [CatalogImportPriceController::class, 'create'])->name('catalog.price.create');
        Route::post('price-upload', [CatalogImportPriceController::class, 'upload'])->name('catalog.price.upload');

        Route::group(['prefix' => 'products'], function () {
            Route::resource('otvody', CatalogOtvodyContoller::class)->names('catalog.product.otvody');
            Route::resource('perehody', CatalogPerehodyController::class)->names('catalog.product.perehody');
            Route::resource('troiniki', CatalogTroinikiController::class)->names('catalog.product.troiniki');
            Route::resource('dnisha', CatalogDnishaController::class)->names('catalog.product.dnisha');
            Route::resource('category', CatalogProductCategoryController::class)->names('catalog.product.category');
            Route::get('category/{category}/create', [CatalogProductCategoryController::class, 'createFromParent'])
                ->name('catalog.product.parentcategory.create');
        });
    });

    Route::group(['prefix' => 'content'], function () {

        Route::group(['prefix' => 'records'], function () {
            Route::resource('category', ContentRecordCategoryController::class)->names('content.records.category');
            Route::resource('record', ContentRecordController::class)->names('content.records.record');
        });

    });
});