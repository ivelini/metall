<?php


namespace App\Repositories\Content;


use App\Repositories\CoreRepository;
use App\Models\Content\ContentSheetWorkerCategory as Model;
use App\Helpers\ImageHelper;
use App\Helpers\ModelAttributeHelper;

class ContentSheetWorkerCategoryRepository extends CoreRepository
{
    protected $imageHelper;
    protected $modelAttributeHelper;

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

    private function getOrderCategoryFomCompany($company)
    {
        $categories = $this->startConditions()
            ->where('company_id', $company->id)
            ->with('workers', 'workers.image:id,path,content_sheet_worker_id')
            ->get()
            ->sortBy('order');

        return $categories;
    }

    public function getCategoriesIncludeWorkersFromCompany($company)
    {
        $categories = $this->getOrderCategoryFomCompany($company);

        foreach ($categories as $category) {
            foreach ($category->workers as $worker) {
                $this->imageHelper->getImgPathFromModel($worker, 'large');
            }

            $category->workers = $category->workers->chunk(4);
        }

        return $categories;
    }

    public function getAttributeCategoriesIncludeWorkersFromCompanyForFrontend($company)
    {
        $categories = $this->getOrderCategoryFomCompany($company);

        $workers = collect();
        foreach ($categories as $category) {
            foreach ($category->workers as $worker) {
                    $this->imageHelper->getImgPathFromModel($worker, 'medium');
                    $worker->img = !empty($worker->image->img) ? $worker->image->img : NULL;

            }

            if ($category->workers->count() > 0) {
                $workers[$category->h1] = $this->modelAttributeHelper->getAttributesFromCollectionModels($category->workers,
                    ['position', 'name', 'phone', 'email', 'img']);
            }
        }

        return $workers;
    }
}