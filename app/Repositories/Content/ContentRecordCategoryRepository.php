<?php


namespace App\Repositories\Content;


use App\Helpers\ModelAttributeHelper;
use App\Repositories\CoreRepository;
use App\Models\Content\ContentRecordCategory as Model;
use Illuminate\Support\Facades\Auth;
use App\Helpers\ImageHelper;

class ContentRecordCategoryRepository extends CoreRepository
{
    private $modelAttributeHelper;
    private $imageHelper;

    public function __construct()
    {
        parent::__construct();
        $this->modelAttributeHelper = new ModelAttributeHelper();
        $this->imageHelper = new ImageHelper();

    }

    public function getModelClass()
    {
        return Model::class;
    }

    /**
     * Если категория с таким именем существует - true, если нет - false
     *
     * @param $categoryName
     * @return bool
     */
    public function isCategoryNameExist($categoryName) {
        $nameCount = $this->startConditions()
            ->select('id', 'company_id', 'h1')
            ->where('company_id', Auth::user()->company()->first()->id)
            ->where('h1', $categoryName)
            ->get()->count();

        if ($nameCount > 0) {
            return true;
        }
        return false;
    }

    public function getCategoriesFromCompanyId($id)
    {
        $categories = $this->startConditions()
            ->where('company_id', $id)
            ->with(['records'])
            ->get();

        foreach($categories as $category) {
            $category->records_count = $category->records()->get()->count();
        }

        return $categories;
    }

    public function getCategoriesFromCompanyIdForRecord($companyId)
    {
        $categories = $this->startConditions()
            ->select('id', 'company_id', 'h1')
            ->where('company_id', $companyId)
            ->get();

        return $categories;
    }

    public function getCategory($id)
    {
        $category = $this->startConditions()
            ->where('id', $id)
            ->get()
            ->first();

        return $category;

    }

    public function getRecordsFromCategoryId($id)
    {
        $records = $this->startConditions()->where('id', $id)
            ->with(['records' => function($query) {
                $query->select('id', 'content_record_category_id', 'h1', 'slug', 'is_published', 'created_at');
            }
            ])
            ->first()
            ->records;

        return $records;
    }

    public function getAttributeCategoriesFromCompanyId($id, $attributes = [])
    {
        $categories = $this->getCategoriesFromCompanyIdNotRelations($id);

        $value = $this->modelAttributeHelper->getAttributesFromCollectionModels($categories, $attributes);

        return $value;
    }

    private function getCategoriesFromCompanyIdNotRelations($id)
    {
        $categories = $this->startConditions()
            ->where('company_id', $id)
            ->with(['records'])
            ->get();

        return $categories;
    }

    public function getAttributeCategoryForFrontendCategory($category)
    {
        $this->imageHelper->getImgPathFromModel($category, 'small', true);
        $category->img_original = $category->image->img_original;

        $filtered = $this->modelAttributeHelper->getAttributesFromModel($category, ['h1', 'img_original']);

        return $filtered;
    }
}