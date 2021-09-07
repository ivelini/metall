<?php


namespace App\Repositories\Content;


use App\Repositories\CoreRepository;
use App\Models\ContentRecordCategory as Model;
use Illuminate\Support\Facades\Auth;

class ContentRecordCategoryRepository extends CoreRepository
{

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
                $query->select('id', 'content_record_category_id', 'h1', 'slug', 'created_at');
            }
            ])
            ->first()
            ->records;

        return $records;
    }
}