<?php


namespace App\Repositories\Content;


use App\Helpers\ImageHelper;
use App\Repositories\CoreRepository;
use App\Models\Content\ContentSheetMainPage as Model;
use App\Helpers\ModelAttributeHelper;

class ContentSheetMainPageRepository extends CoreRepository
{
    protected $modelAttributeHelper;
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

    public function getWorkersForFrontenCompanyMain($company)
    {
        $workerCategoryId = $this->startConditions()
            ->where('company_id', $company->id)
            ->first()
            ->worker_category_id;

        $workersCategory = $company->contentSheetWorkerCategory->where('id', $workerCategoryId)->first();
        $workers = $workersCategory->workers()->with('image:id,content_sheet_worker_id,path')->get();

        foreach ($workers as $worker) {
            $worker->category = $workersCategory->h1;
            $this->imageHelper->getImgPathFromModel($worker);
            $worker->img = (!empty($worker->image->img) ? $worker->image->img : NULL);
        }

        $workers = $this->modelAttributeHelper->getAttributesFromCollectionModels($workers,
            ['id', 'position', 'name', 'phone', 'email', 'category', 'img']);

        return $workers;
    }

}