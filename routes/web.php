<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminPanel\Catalog\CatalogImportPriceController;

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

    Route::group(['prefix' => 'catalog', 'namespace' => 'AdminPanel\Catalog'], function () {
        Route::get('price-import', [CatalogImportPriceController::class, 'create'])->name('catalog.price.create');
        Route::post('price-upload', [CatalogImportPriceController::class, 'upload'])->name('catalog.price.upload');
    });
});