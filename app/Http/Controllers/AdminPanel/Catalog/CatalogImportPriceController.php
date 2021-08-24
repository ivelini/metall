<?php

namespace App\Http\Controllers\AdminPanel\Catalog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Services\Catalog\InputPriceService;
use App\Jobs\ImportPriceJob;


class CatalogImportPriceController extends Controller
{
    protected $inputPriceService;

    public function __construct()
    {
        $this->inputPriceService = new InputPriceService();
    }

    public function create()
    {
        return view('admin_panel.catalog.import-price');
    }

    /**
     *  Загрузка прайс листа
     *
     * @param Request $request
     */
    public function upload(Request $request)
    {

        $request->validate([
            'price' => 'mimes:xlsx,xls,csv|required',
        ]);

        $companyId = Auth::user()->company()->first()->id;
        $path = Storage::disk('local')->putFileAs('tmp', $request->file('price'), 'price_company-id_' . $companyId . '.xlsx');

        $result = $this->inputPriceService->input($path, $companyId);

        if (gettype($result) == 'string') {

            return redirect()
                ->route('catalog.price.create')
                ->withErrors($result);
        }
        else {
            return redirect()
                ->route('catalog.price.create')
                ->with(['success' => 'Прайс добавлен в очередь загрузки']);
        }

    }



}
