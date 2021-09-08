<?php


namespace App\Repositories\Content;


use App\Helpers\ImageHelper;
use App\Repositories\CoreRepository;
use App\Models\ContentSheetWorker as Model;
use Illuminate\Support\Facades\Auth;

class ContentSheetWorkerRepository extends CoreRepository
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

    public function getWorkerForEdit($id)
    {
        $worker = $this->startConditions()
            ->where('id', $id)
            ->with('category')
            ->first();

        $worker->category_id = $worker->category->id;
        $this->imageHelper->getImgPathFromModel($worker, 'large');

        return $worker;
    }

    public function getWorker($id)
    {
        $worker = $this->startConditions()
            ->where('id', $id)
            ->first();

        return $worker;
    }

}