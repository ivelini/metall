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

    public function getCategory($id)
    {
        $category = $this->startConditions()
            ->where('id', $id)
            ->get()
            ->first();

        return $category;

    }
}