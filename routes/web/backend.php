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
use App\Http\Controllers\AdminPanel\Media\ImageController;
use App\Http\Controllers\AdminPanel\Settings\CompanyInformationController;
use App\Http\Controllers\AdminPanel\Settings\SliderController;
use App\Http\Controllers\AdminPanel\Settings\SliderImageController;
use App\Http\Controllers\AdminPanel\Settings\MenuController;
use App\Http\Controllers\AdminPanel\Content\ContentSheetMainPageController;
use App\Http\Controllers\AdminPanel\Content\ContentSheetMainCatalogController;
use App\Http\Controllers\AdminPanel\Content\ContentSheetPageInformationController;
use App\Http\Controllers\AdminPanel\Content\ContentSheetMainDividerController;
use App\Http\Controllers\AdminPanel\Content\ContentSheetMainServicesController;


Route::group(['domain' => env('APP_URL'), 'prefix' => 'admin-panel', 'middleware' => 'auth'], function () {
    Route::redirect('/', '/admin-panel/dashboard');
    Route::view('/dashboard', 'admin_panel.dashboard')->name('dashboard');

    Route::group(['prefix' => 'media'], function () {

        Route::delete('image/{image}', [ImageController::class, 'destroy'])->name('media.image.destroy');
    });

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
            Route::get('category/{category}', [CatalogProductCategoryController::class, 'editParent'])
                ->name('catalog.product.category.editParent');
//            Route::match(['put', 'patch'], 'category/{category}', [CatalogProductCategoryController::class, 'updateParent'])
//                ->name('catalog.product.category.updateParent');
        });
    });

    Route::group(['prefix' => 'content'], function () {

        Route::group(['prefix' => 'records'], function () {
            Route::resource('category', ContentRecordCategoryController::class)->names('content.records.category');
            Route::resource('record', ContentRecordController::class)->names('content.records.record');
        });

        Route::group(['prefix' => 'sheet'], function () {

            Route::match(['put', 'patch'], 'info-update', [ContentSheetPageInformationController::class, 'update'])
                ->name('content.sheet.info-update');

            Route::group(['prefix' => 'main'], function () {

                Route::get('/', [ContentSheetMainPageController::class, 'edit'])->name('content.sheet.main.edit');

                Route::resource('divider', ContentSheetMainDividerController::class)
                    ->names('content.sheet.main.divider');

                Route::resource('services', ContentSheetMainServicesController::class)
                    ->names('content.sheet.main.services');
            });

            Route::match(['put', 'patch'], 'main', [ContentSheetMainPageController::class, 'update'])
                ->name('content.sheet.main.update');

            Route::get('catalog', [ContentSheetMainCatalogController::class, 'edit'])->name('content.sheet.main.catalog.edit');
            Route::match(['put', 'patch'], 'catalog', [ContentSheetMainCatalogController::class, 'update'])
                ->name('content.sheet.main.catalog.update');

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

    Route::group(['prefix' => 'settings'], function () {

        Route::group(['prefix' => 'theme'], function () {
//            Route::get('default',)
        });
        Route::get('general', [CompanyInformationController::class, 'generaledit'])
            ->name('settings.companyInformation.generalEdit');
        Route::match(['put', 'patch'], 'general', [CompanyInformationController::class, 'generalUpdate'])
            ->name('settings.companyInformation.generalUpdate');

        Route::get('menu', [MenuController::class, 'edit'])
            ->name('settings.menu.edit');

        Route::get('company_information', [CompanyInformationController::class, 'edit'])
            ->name('settings.companyInformation.edit');
        Route::match(['put', 'patch'], 'company_information', [CompanyInformationController::class, 'update'])
            ->name('settings.companyInformation.update');

        Route::resource('slider', SliderController::class)->names('settings.slider');
        Route::resource('slider/{slider}/slide', SliderImageController::class)->names('settings.slider.slide');
    });
});