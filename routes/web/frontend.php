<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\Company\Page\MainController;
use App\Http\Middleware\MappingDomainCompany;
use App\Http\Controllers\Frontend\Company\Sections\Records\RecordCategoryController;

Route::group(['domain' => env('APP_URL')], function () {
    Route::get('/', [\App\Http\Controllers\Frontend\Main\MainController::class, 'index']);
});

Route::middleware(MappingDomainCompany::class)->group(function () {

    Route::get('/', [MainController::class, 'index']);

    Route::get('/record/cat/{category}', [RecordCategoryController::class, 'show'])
        ->name('front.company.record.category');
});