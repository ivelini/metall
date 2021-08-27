<?php

namespace App\Http\Controllers\AdminPanel\Catalog;

use App\Http\Controllers\Controller;
use App\Repositories\Catalog\CatalogProductTablesRepository;
use Illuminate\Http\Request;
use App\Repositories\Catalog\CatalogCategoryProductRepository;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CatalogProductCategoryRequest;
use function MongoDB\BSON\fromJSON;

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
    public function store(CatalogProductCategoryRequest $request)
    {

        $input = $request->input();
        $companyId = Auth::user()->company()->first()->id;

        empty($input['is_published']) == true ? $input['is_published'] = 0 : $input['is_published'] = 1;

        //Собираем ключи для фильтра
        $filtrKeyValue = [];
        foreach ($input as $key => $value) {
            if (mb_strripos($key, ':') > 0 && $value != NULL) {
                $key = substr($key, 0, strpos($key, ':'));
                $filtrKeyValue[$key] = $value;
            }
        }

        //Если нет ни одного ключа
        if (count($filtrKeyValue) == 0) {
            return redirect()->back()
                ->withInput()
                ->with(['alert' => 'Хотя бы один параметр фильтра должен быть выбран']);
        }

        //Сереализуем фильтр
        $filtrKeyValue = json_encode($filtrKeyValue);

        //Добавляем днные в таблицу
        $prouctCategoryTable = $this->catalogProductCategoryRepository->startConditions();
        $prouctCategoryTable->parent_id = $input['parent_id'];
        $prouctCategoryTable->company_id = $companyId;
        $prouctCategoryTable->category_name = $input['category_name'];
        $prouctCategoryTable->catalog_product_table_name = $input['catalog_product_table_name'];
        $prouctCategoryTable->columns_name = $filtrKeyValue;
        $prouctCategoryTable->is_published = $input['is_published'];
        $prouctCategoryTable->save();

        return redirect()
            ->route('catalog.product.category.index')
            ->with(['success' => 'Категория успешно добавлена']);
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
        $category = $this->catalogProductCategoryRepository->startConditions()
            ->where('id', $id)
            ->first();

        $columns = $this->catalogProductTablesRepository->getColumnsFromTableNameForFilter($category->catalog_product_table_name);

        $uniqVolumes =$this->catalogProductTablesRepository->getUniqVolumeFromColumn($columns, $category->catalog_product_table_name);
        $selectedVolumeFromColumns = (array) json_decode($category->columns_name);

        $uniqVolumesAndSelected = $this->catalogProductTablesRepository->selectUniqVolumes($uniqVolumes, $selectedVolumeFromColumns);

        return view('admin_panel.catalog.product.category.edit', compact('category', 'uniqVolumesAndSelected'));
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
        dd(__METHOD__,$request, $id);
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
