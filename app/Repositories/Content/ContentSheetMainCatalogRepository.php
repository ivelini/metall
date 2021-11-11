<?php


namespace App\Repositories\Content;


use App\Helpers\ImageHelper;
use App\Repositories\CoreRepository;
use App\Models\Content\ContentSheetMainCatalog as Model;
use App\Helpers\ModelAttributeHelper;

class ContentSheetMainCatalogRepository extends CoreRepository
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

    public function getModelFromCompanyId($companyId)
    {
        $model = $this->startConditions()
            ->where('company_id', $companyId)
            ->first();

        return $model;
    }

    public function getContentFromCompanyId($companyId)
    {
        $content = $this->startConditions()
            ->where('company_id', $companyId)
            ->pluck('content')
            ->first();

        return $content;
    }

}