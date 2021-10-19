<?php


namespace App\Repositories\Catalog;

use App\Models\Catalog\CatalogProductsCategory as Model;
use App\Repositories\CoreRepository;
use Illuminate\Support\Facades\Storage;
use App\Helpers\ImageHelper;
use App\Helpers\ModelAttributeHelper;

class CatalogCategoryProductRepository extends CoreRepository
{
    private $imageHelper;
    private $modelAttributeHelper;

    public function __construct()
    {
        parent::__construct();
        $this->imageHelper = new ImageHelper();
        $this->modelAttributeHelper = new ModelAttributeHelper();
    }

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
            ->select('id', 'parent_id', 'title', 'h1', 'slug', 'company_id', 'category_name',
                'catalog_product_table_name', 'columns_name', 'is_published')
            ->where('parent_id', 0)
            ->with('children', 'image')
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

    public function getCategory($id)
    {
        $category = $this->startConditions()
            ->where('id', $id)
            ->with('image')
            ->first();

        if(!empty($category->image->path)) {
            $category->img = '/storage' . mb_substr($category->image->path, 0, mb_strripos($category->image->path, '.'))
                . '_medium.jpg';
        }

        return $category;
    }

    public function getPublishedCategoriesFromCompanyForFrontend($company)
    {

        $categories = $this->getCategoriesFromCompanyId($company);

        foreach ($categories as $category) {
            $this->imageHelper->getImgPathFromModel($category, 'medium');
            $category->img = !empty($category->image->img) ? $category->image->img : NULL;
        }

        $categories = $this->modelAttributeHelper->getAttributesFromCollectionModels($categories, ['id', 'category_name', 'img']);

        return $categories;
    }

    public function getPublishedCategoriesFromCompanyForFrontendSidebar($company)
    {
        $categories = $company->catalogProductCategories()
            ->select('id', 'category_name', 'is_published')
            ->where('parent_id', 0)
            ->where('is_published', 1)
            ->with([
                'children' => function($query) {
                    $query->select('id', 'parent_id', 'category_name', 'is_published')
                        ->where('is_published', 1);
                }
            ])
            ->get();

        $categories = $categories->reject(function ($value) {
            if ($value->category_name == 'Без категории') {
                return true;
            }
        });
        foreach ($categories as $category) {
            $category->children = $this->modelAttributeHelper->getAttributesFromCollectionModels($category->children);
        }

        $categories = $this->modelAttributeHelper->getAttributesFromCollectionModels($categories);

        return $categories;
    }
}