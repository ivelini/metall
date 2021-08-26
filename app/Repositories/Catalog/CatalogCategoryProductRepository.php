<?php


namespace App\Repositories\Catalog;

use App\Models\CatalogProductsCategory as Model;
use App\Repositories\CoreRepository;

class CatalogCategoryProductRepository extends CoreRepository
{

    public function getModelClass()
    {
        return Model::class;
    }

    public function getListNameCategoryFromCompanyId($companyId)
    {
        $listsName = $this->startConditions()
            ->where('company_id', $companyId)
            ->pluck('category_name');

        return $listsName;
    }

    public function getCategoriesFromCompanyId($modelCompany)
    {

        $collectCategories = $modelCompany->catalogProductCategories()
            ->select('id', 'parent_id', 'company_id', 'category_name',
                'catalog_product_table_name', 'columns_name', 'is_published')
            ->where('parent_id', 0)
            ->with('children')
            ->get();

        $filtered = $collectCategories->reject(function ($value) {
            if ($value->category_name == 'Без категории') {
                return true;
            }
        });

        return $filtered;
    }

    public function getModelForId($id)
    {
        $model =  $this->startConditions()->where('id', $id)->first();
        return $model;
    }
}