<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\Company\Page\MainController;
use App\Http\Middleware\MappingDomainCompany;
use App\Http\Controllers\Frontend\Company\Sections\Records\RecordCategoryController;
use App\Http\Controllers\Frontend\Company\Sections\Records\RecordController;
use App\Http\Controllers\Frontend\Company\Page\WorkerController;
use \App\Http\Controllers\Frontend\Company\Page\CertificateController;
use App\Http\Controllers\Frontend\Company\Page\TimelinePageController;
use App\Http\Controllers\Frontend\Company\Page\StandardController;
use App\Http\Controllers\Frontend\Company\Page\ShipmentController;
use App\Http\Controllers\Frontend\Company\Page\ContactController;
use App\Http\Controllers\Frontend\Company\Sections\Catalog\CatalogCategoryController;
use App\Http\Controllers\Frontend\Company\Action\SendFormController;

Route::group(['domain' => env('APP_URL')], function () {
    Route::get('/', [\App\Http\Controllers\Frontend\Main\MainController::class, 'index']);
});

Route::middleware(MappingDomainCompany::class)->group(function () {

    Route::get('/', [MainController::class, 'index'])->name('home');
    Route::match(['put', 'putch'], 'send/request', [SendFormController::class, 'sendRequest'])
        ->name('frontend.company.action.send.request');

    Route::get('/record/cat/{category}', [RecordCategoryController::class, 'show'])
        ->name('frontend.company.content.record.category');

    Route::get('/record/{category}/{record}', [RecordController::class, 'show'])
        ->name('frontend.company.content.record');

    Route::get('/workers', [WorkerController::class, 'index'])
        ->name('frontend.company.workers');

    Route::get('/certificates', [CertificateController::class, 'index'])
        ->name('frontend.company.content.sheet.certificates');

    Route::get('/timeline/{timeline}', [TimelinePageController::class, 'show'])
        ->name('frontend.company.content.sheet.timeline.page');

    Route::get('/standards', [StandardController::class, 'index'])
        ->name('frontend.company.content.sheet.standarts');

    Route::get('/shipment', [ShipmentController::class, 'index'])
        ->name('frontend.company.content.sheet.shipment');

    Route::get('/shipment/{shipment}', [ShipmentController::class, 'show'])
        ->name('frontend.company.content.sheet.shipment.page');

    Route::get('/contacts', [ContactController::class, 'index'])
        ->name('frontend.company.company.information');

    Route::group(['prefix' => 'catalog'], function () {
        Route::get('/', [CatalogCategoryController::class, 'index'])
            ->name('frontend.company.catalog.category.index');

        Route::get('/category/{category}', [CatalogCategoryController::class, 'showParent'])
            ->name('frontend.company.catalog.category.parent');

        Route::get('/{parent}/{category}', [CatalogCategoryController::class, 'show'])
            ->name('frontend.company.catalog.product.category');

        Route::get('/{category}/{standard}/{du}', [CatalogCategoryController::class, 'categoryFilter'])
            ->name('frontend.company.catalog.category.standard.du');
    });
});