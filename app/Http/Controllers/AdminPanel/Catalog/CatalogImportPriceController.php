<?php

namespace App\Http\Controllers\AdminPanel\Catalog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CatalogImportPriceController extends Controller
{
    public function create() {
        return view('admin_panel.catalog.import-price');
    }

    public function upload(Request $request) {

        $request->validate([
            'price' => 'mimes:xlsx,xls,csv',
        ]);

        Storage::disk('local')->putFileAs('tmp', $request->file('price'), 'temp.xlsx');
    }
}
