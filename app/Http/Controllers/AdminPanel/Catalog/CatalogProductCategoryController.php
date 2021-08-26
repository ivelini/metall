<?php

namespace App\Http\Controllers\AdminPanel\Catalog;

use App\Http\Controllers\Controller;
use App\Repositories\Catalog\CatalogProductTablesRepository;
use Illuminate\Http\Request;
use App\Repositories\Catalog\CatalogCategoryProductRepository;
use Illuminate\Support\Facades\Auth;

class CatalogProductCategoryController extends Controller
{

    protected $catalogProductCategoryRepository;
    protected $catalogProductTablesRepository;

    public function __construct()
    {
        $this->catalogProductCategoryRepository = new CatalogCategoryProductRepository();
        $this->catalogProductTablesRepository = new CatalogProductTablesRepository();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $modelCompany = Auth::user()->company()->first();

        $categories = $this->catalogProductCategoryRepository->getCategoriesFromCompanyId($modelCompany);

        return view('admin_panel.catalog.product.category.index', compact('categories'));
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

    public function createFromParent($parentId)
    {

        $parentCategory = $this->catalogProductCategoryRepository->getModelForId($parentId);
        $column = $this->catalogProductTablesRepository
            ->getColumnsFromTableNameForFilter($parentCategory->catalog_product_table_name);

        $uniqVolumes = $this->catalogProductTablesRepository->getUniqVolumeFromColumn($column, $parentCategory->catalog_product_table_name);

        return view('admin_panel.catalog.product.category.create', compact('parentCategory', 'uniqVolumes'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $input = $request->input();
        $companyId = Auth::user()->company()->first()->id;

        empty($input['is_published']) == true ? $input['is_published'] = 0 : $input['is_published'] = 1;

        $filtrKeyValue = [];
        foreach ($input as $key => $value) {
            if (strpos($key, '_filtr') > 0 && $value != NULL) {
                $key = substr($key, 0, strpos($key, '_filtr'));
                $filtrKeyValue[$key] = $value;
            }
        }

        $filtrKeyValue = json_encode($filtrKeyValue);
        dd(__METHOD__, $companyId, $input,$filtrKeyValue);
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
