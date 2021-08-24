<?php


namespace App\Repositories\Catalog;

use App\Models\CatalogProductsCategory as Model;
use App\Repositories\CoreRepository;

class CatalogCatgoryProductsRepository extends CoreRepository
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
}