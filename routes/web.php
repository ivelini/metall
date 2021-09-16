<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminPanel\Catalog\CatalogImportPriceController;
use App\Http\Controllers\AdminPanel\Catalog\CatalogOtvodyContoller;
use App\Http\Controllers\AdminPanel\Catalog\CatalogPerehodyController;
use App\Http\Controllers\AdminPanel\Catalog\CatalogTroinikiController;
use App\Http\Controllers\AdminPanel\Catalog\CatalogDnishaController;
use App\Http\Controllers\AdminPanel\Catalog\CatalogProductCategoryController;
use App\Http\Controllers\AdminPanel\Content\ContentRecordCategoryController;
use App\Http\Controllers\AdminPanel\Content\ContentRecordController;
use App\Http\Controllers\AdminPAnel\Content\ContentSheetWorkerCategoryController;
use App\Http\Controllers\AdminPAnel\Content\ContentSheetWorkerController;
use App\Http\Controllers\AdminPanel\Content\ContentSheetCertificateController;
use App\Http\Controllers\AdminPanel\Content\ContentSheetTimelineLineController;
use App\Http\Controllers\AdminPanel\Content\ContentSheetTimelinePageController;
use App\Http\Controllers\AdminPanel\Content\ContentSheetStandartController;
use App\Http\Controllers\AdminPanel\Content\ContentSheetShipmentController;

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

        Route::group(['prefix' => 'sheet'], function () {

            Route::group(['prefix' => 'workers'], function () {
                Route::match(['put', 'patch'], 'category/order-renew', [ContentSheetWorkerCategoryController::class, 'orderRenew'])
                    ->name('content.sheet.worker.category.orderrenew');
                Route::resource('category', ContentSheetWorkerCategoryController::class)->names('content.sheet.worker.category');
                Route::resource('worker', ContentSheetWorkerController::class)->names('content.sheet.worker');
            });

            Route::resource('certificate', ContentSheetCertificateController::class)->names('content.sheet.certificate');

            Route::group(['prefix' => 'timelines'], function () {
                Route::resource('page', ContentSheetTimelinePageController::class)->names('content.sheet.timeline.page');

                Route::resource('page/{page}/line', ContentSheetTimelineLineController::class)->names('content.sheet.timeline.line');
                Route::match(['put', 'patch'], 'page/{page}/order-renew', [ContentSheetTimelinePageController::class, 'orderRenew'])
                    ->name('content.sheet.timeline.page.orderrenew');
            });

            Route::resource('standard', ContentSheetStandartController::class)->names('content.sheet.standard');
            Route::resource('shipment', ContentSheetShipmentController::class)->names('content.sheet.shipment');
        });
    });
});