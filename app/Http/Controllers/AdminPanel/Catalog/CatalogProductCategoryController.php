<?php

namespace App\Http\Controllers\AdminPanel\Catalog;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Repositories\Catalog\CatalogProductTablesRepository;
use App\Repositories\ImageRepository;
use App\Services\Content\CreateAndUpdateContentTableService;
use Illuminate\Http\Request;
use App\Repositories\Catalog\CatalogCategoryProductRepository;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CatalogProductCategoryRequest;

class CatalogProductCategoryController extends Controller
{

    protected $catalogProductCategoryRepository;
    protected $catalogProductTablesRepository;
    protected $imageHelper;
    protected $imageRepository;
    protected $createAndUpdateContentTableService;

    public function __construct()
    {
        $this->catalogProductCategoryRepository = new CatalogCategoryProductRepository();
        $this->catalogProductTablesRepository = new CatalogProductTablesRepository();
        $this->imageHelper = new ImageHelper();
        $this->imageRepository = new ImageRepository();
        $this->createAndUpdateContentTableService = new CreateAndUpdateContentTableService();
    }

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

    public function store(CatalogProductCategoryRequest $request)
    {
        $companyId = Auth::user()->company()->first()->id;

        $filterKey = $this->getFilterKey($request->input());

        //Если нет ни одного ключа
        if (count($filterKey) == 0) {
            return redirect()->back()
                ->withInput()
                ->with(['alert' => 'Хотя бы один параметр фильтра должен быть выбран']);
        }

        //Сереализуем фильтр
        $filterKey = json_encode($filterKey);

        //Добавляем днные в таблицу
        $prouctCategoryTable = $this->catalogProductCategoryRepository->startConditions();
        $this->createAndUpdateContentTableService->setModifiedData('columns_name', $filterKey);
        $this->createAndUpdateContentTableService->save($prouctCategoryTable, $request);

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
        $category = $this->catalogProductCategoryRepository->getCategory($id);

        $columns = $this->catalogProductTablesRepository->getColumnsFromTableNameForFilter($category->catalog_product_table_name);

        $uniqVolumes =$this->catalogProductTablesRepository->getUniqVolumeFromColumn($columns, $category->catalog_product_table_name);
        $selectedVolumeFromColumns = (array) json_decode($category->columns_name);

        $uniqVolumesAndSelected = $this->catalogProductTablesRepository->selectUniqVolumes($uniqVolumes, $selectedVolumeFromColumns);

        return view('admin_panel.catalog.product.category.edit', compact('category', 'uniqVolumesAndSelected'));
    }

    public function editParent($id)
    {
//        dd(__METHOD__);
        $category = $this->catalogProductCategoryRepository->getCategory($id);

        $columns = $this->catalogProductTablesRepository->getColumnsFromTableNameForFilter($category->catalog_product_table_name);

        return view('admin_panel.catalog.product.category.edit-parent', compact('category'));
    }

    public function update(Request $request, $id)
    {
        if ($request->input('parent_id') == 0) {
            //Обновляем категорию
            $productCategoryTable = $this->catalogProductCategoryRepository->startConditions()
                ->where('id', $id)
                ->first();

            $this->createAndUpdateContentTableService->update($productCategoryTable, $request);

            return redirect()
                ->route('catalog.product.category.index')
                ->with(['success' => 'Категория "' . $request->get('category_name') . '" успешно обновлена']);
        }
        else {
            $filterKey = $this->getFilterKey($request->input());

            //Если нет ни одного ключа
            if (count($filterKey) == 0) {
                return redirect()->back()
                    ->withInput()
                    ->with(['alert' => 'Хотя бы один параметр фильтра должен быть выбран']);
            }

            //Сереализуем фильтр
            $filterKey = json_encode($filterKey);

            //Обновляем категорию
            $productCategoryTable = $this->catalogProductCategoryRepository->startConditions()
                ->where('id', $id)
                ->first();
            $this->createAndUpdateContentTableService->setModifiedData('columns_name', $filterKey);
            $this->createAndUpdateContentTableService->update($productCategoryTable, $request);

            return redirect()
                ->route('catalog.product.category.index')
                ->with(['success' => 'Категория "' . $request->get('category_name') . '" успешно обновлена']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->catalogProductCategoryRepository->startConditions()
            ->where('id', $id)
            ->first()
            ->forceDelete();

        return redirect()
            ->route('catalog.product.category.index')
            ->with(['success' => 'Категория успешно удалена']);
    }

    protected function getFilterKey($input)
    {
        //Собираем ключи для фильтра
        $filterKeyValue = [];
        foreach ($input as $key => $value) {
            if (mb_strripos($key, ':') > 0 && $value != NULL) {
                $key = substr($key, 0, strpos($key, ':'));
                $filterKeyValue[$key] = $value;
            }
        }

        $filterKey = $filterKeyValue;

        return $filterKey;
    }
}