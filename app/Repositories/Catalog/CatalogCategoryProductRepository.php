<?php


namespace App\Repositories\Catalog;

use App\Helpers\CatalogFilterHelper;
use App\Models\Catalog\CatalogProductsCategory as Model;
use App\Repositories\CoreRepository;
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

        $this->imageHelper->getImgPathFromModel($category);
        $category->img = !empty($category->image->img) ? $category->image->img : NULL;

//        if(!empty($category->image->path)) {
//            $category->img = '/storage' . mb_substr($category->image->path, 0, mb_strripos($category->image->path, '.'))
//                . '_medium.jpg';
//        }

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

            if ($value->children->count() == 0) {
                return true;
            }
        });

        foreach ($categories as $category) {
            $category->children = $this->modelAttributeHelper->getAttributesFromCollectionModels($category->children);
        }

        $categories = $this->modelAttributeHelper->getAttributesFromCollectionModels($categories);

        return $categories;
    }

    public function getChildrenCategoryFromParentIdForCompanyFrontend($id)
    {
        $children = $this->startConditions()
            ->where('id', $id)
            ->with([
                'children' => function($query) {
                    $query
                        ->select('id', 'parent_id', 'company_id', 'category_name')
                        ->where('is_published', 1);
                },
                'children.image:id,path,catalog_product_category_id'
            ])
            ->first()
            ->children;

        foreach ($children as $child) {
            $this->imageHelper->getImgPathFromModel($child, 'medium');
            $child->img = !empty($child->image->img) ? $child->image->img : NULL;
        }

        $children = $this->modelAttributeHelper->getAttributesFromCollectionModels($children, ['id', 'parent_id', 'category_name', 'img']);

        return $children;
    }

    public function getProductsFromFilterCategoryId($id)
    {
        $category = $this->getCategory($id);
        $catalogFilterHelper = new CatalogFilterHelper();

        $catalogFilterHelper->setTable($category->catalog_product_table_name);
        $catalogFilterHelper->addParams($category->columns_name);

        $result = $catalogFilterHelper->getResult();

        return $result;
    }

    public function getProductsFromCategoryStandardDu($category, $standard, $du)
    {
        $catalogFilterHelper = new CatalogFilterHelper();

        $catalogFilterHelper->setTable('catalog_' . $category);

        //Если DU состоит из несольких параметров, разделенных "-"
        $du = explode('-', $du);

        if (!empty($du)) {

            if (count($du) > 1) {
                for ($i = 1; $i <= count($du); $i++) {
                    $catalogFilterHelper->addParams('du' . $i, $du[$i - 1]);
                }
            }
            else {
                $catalogFilterHelper->addParams('du', $du[0]);
            }
        }

        $catalogStandardepository = new CatalogStandardRepository();

        $catalogFilterHelper->addParams('catalog_standards_product_id', $catalogStandardepository->getIDFromStandardCode($standard));

        $products = $catalogFilterHelper->getResult(true);

        return $products;

    }

    public function is_filterForGostOnly($categoryId)
    {
        $category = $this->getCategory($categoryId);

        $filter = (array) json_decode($category->columns_name);

        if(count($filter) == 1 && !empty($filter['catalog_standards_product_id'])){
            return true;
        }

        return false;
    }

    public function getCategoryContentForForntendCompany($categoryId)
    {
        $category = $this->getCategory($categoryId);

        $content = $this->modelAttributeHelper->getAttributesFromModel($category,
            ['h1', 'content', 'img']);

        return $content;
    }
}