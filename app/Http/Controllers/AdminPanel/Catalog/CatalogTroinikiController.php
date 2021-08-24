<?php

namespace App\Http\Controllers\AdminPanel\Catalog;

use App\Http\Controllers\Controller;
use App\Repositories\Catalog\CatalogTroinikiRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CatalogTroinikiController extends Controller
{
    protected $catalogTroinikiRepository;

    public function __construct()
    {
        $this->catalogTroinikiRepository = new CatalogTroinikiRepository();
    }

    public function index()
    {
        $productName = 'Тройники';
        $companyId = Auth::user()->company()->get()->first()->id;
        $listProducts = $this->catalogTroinikiRepository->getAllForCompanyId($companyId);

        return view('admin_panel.catalog.product.index', compact('listProducts', 'productName'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
