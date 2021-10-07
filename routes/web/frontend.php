<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\Company\Page\MainController;
use App\Http\Middleware\MappingDomainCompany;

Route::group(['domain' => env('APP_URL')], function () {
    Route::get('/', [\App\Http\Controllers\Frontend\Main\MainController::class, 'index']);
});

Route::middleware(MappingDomainCompany::class)->group(function () {

    Route::get('/', [MainController::class, 'index']);
});