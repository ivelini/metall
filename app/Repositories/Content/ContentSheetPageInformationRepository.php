<?php


namespace App\Repositories\Content;


use App\Repositories\CoreRepository;
use App\Models\Content\ContentSheetPageInformation as Model;
use Illuminate\Support\Facades\Auth;
use App\Helpers\ModelAttributeHelper;
use App\Helpers\ImageHelper;


class ContentSheetPageInformationRepository extends CoreRepository
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

    public function getModelFromSheetPage($sheetName)
    {
        $page = $this->startConditions()
            ->where('company_id', Auth::user()->company()->first()->id)
            ->where('sheet_name', $sheetName)
            ->first();

        return $page;
    }

    public function getInformationFromSheetPage($sheetName)
    {
        $page = $this->getModelFromSheetPage($sheetName);

        if (!empty($page)) {
            $this->imageHelper->getImgPathFromModel($page, 'small', true);
            $page->img = (!empty($page->image->img_original) ? $page->image->img_original : NULL);
            $page = $this->modelAttributeHelper->getAttributesFromModel($page);
        }
        else {
            $page = collect();
        }

        return $page;
    }

}