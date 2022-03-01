<?php


namespace App\Repositories\Content;


use App\Helpers\ImageHelper;
use App\Repositories\CoreRepository;
use App\Models\Content\ContentSheetMainDivider as Model;
use App\Helpers\ModelAttributeHelper;

class ContentSheetMainDividerRepository extends CoreRepository
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

    public function getDividersFromCompany($company)
    {
        $dividers = $this->startConditions()
            ->where('company_id', $company->id)
            ->with('image:id,path,divider_id')
            ->get();

        foreach ($dividers as $divider) {
            $this->imageHelper->getImgPathFromModel($divider, 'medium', true);
            $divider->img = !empty($divider->image->img_original) ? $divider->image->img_original : NULL;
        }

        $dividers = $this->modelAttributeHelper->getAttributesFromCollectionModels($dividers, ['id', 'h1', 'description', 'img']);

        return $dividers;
    }

    public function getDivider($id)
    {
        $divider = $this->startConditions()
            ->where('id', $id)
            ->first();

        return $divider;

    }

    public function getDividerForEdit($id)
    {
        $divider = $this->getDivider($id);

        $this->imageHelper->getImgPathFromModel($divider, 'medium');
        $divider->img = !empty($divider->image->img) ? $divider->image->img : NULL;

        $divider = $this->modelAttributeHelper->getAttributesFromModel($divider, ['id', 'h1', 'description', 'img']);

        return $divider;
    }

}