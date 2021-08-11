<?php

namespace App\Http\Controllers\AdminPanel\Catalog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Services\Catalog\InputPriceService;


class CatalogImportPriceController extends Controller
{


    public function create()
    {
        return view('admin_panel.catalog.import-price');
    }

    /**
     *  Загрузка прайс листа
     *
     * @param Request $request
     * @param InputPriceService $inputPriceService
     */
    public function upload(Request $request, InputPriceService $inputPriceService)
    {

        $request->validate([
            'price' => 'mimes:xlsx,xls,csv',
        ]);

        $path = Storage::disk('local')->putFileAs('tmp', $request->file('price'), 'temp.xlsx');

        $result = $inputPriceService->input($path);

        if (gettype($result) == 'string') {

            return redirect()
                ->route('catalog.price.create')
                ->withErrors($result);
        }
        else {
            return redirect()
                ->route('catalog.price.create')
                ->with(['success' => 'Прайс успешно загружен']);
        }
    }



}
