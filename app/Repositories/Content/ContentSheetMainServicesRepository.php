<?php


namespace App\Repositories\Content;


use App\Helpers\ImageHelper;
use App\Repositories\CoreRepository;
use App\Models\Content\ContentSheetMainServices as Model;
use App\Helpers\ModelAttributeHelper;

class ContentSheetMainServicesRepository extends CoreRepository
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

    public function getServicesFromCompany($company)
    {
        $services = $this->startConditions()
            ->where('company_id', $company->id)
            ->with('image:id,path,services_id')
            ->get();

        foreach ($services as $service) {
            $this->imageHelper->getImgPathFromModel($service, 'medium', true);
            $service->img = !empty($service->image->img_original) ? $service->image->img_original : NULL;
        }

        $services = $this->modelAttributeHelper->getAttributesFromCollectionModels($services, ['id', 'h1', 'description', 'img']);

        return $services;
    }

    public function getService($id)
    {
        $service = $this->startConditions()
            ->where('id', $id)
            ->first();

        return $service;

    }

    public function getServiceForEdit($id)
    {
        $service = $this->getService($id);

        $this->imageHelper->getImgPathFromModel($service, 'medium');
        $service->img = !empty($service->image->img) ? $service->image->img : NULL;

        $service = $this->modelAttributeHelper->getAttributesFromModel($service, ['id', 'h1', 'description', 'img']);

        return $service;
    }
}