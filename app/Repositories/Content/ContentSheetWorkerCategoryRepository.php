<?php


namespace App\Repositories\Content;


use App\Repositories\CoreRepository;
use App\Models\ContentSheetWorkerCategory as Model;
use Illuminate\Support\Facades\Auth;
use App\Helpers\ImageHelper;

class ContentSheetWorkerCategoryRepository extends CoreRepository
{
    protected $imageHelper;

    public function __construct()
    {
        parent::__construct();
        $this->imageHelper = new ImageHelper();
    }

    public function getModelClass()
    {
        return Model::class;
    }

    public function getNextOrderFromCompany($company)
    {

        $nextOrder = $company->contentSheetWorkerCategory->max('order') + 1;

        return $nextOrder;
    }

    public function getWorkerCategoryesFromCompany($company)
    {
        $categoryes = $company->contentSheetWorkerCategory->sortBy('order');

        return $categoryes;
    }

    public function getCategory($id) {

        $category = $this->startConditions()->where('id', $id)->first();

        return $category;

    }

    public function getCategoriesIncludeWorkersFromCompany($company)
    {
        $categories = $this->startConditions()
            ->where('company_id', $company->id)
            ->with('workers')
            ->get()
            ->sortBy('order');

        foreach ($categories as $category) {
            foreach ($category->workers as $worker) {
                $this->imageHelper->getImgPathFromModel($worker, 'extralarge');
            }

            $category->workers = $category->workers->chunk(4);
        }

        return $categories;
    }

}