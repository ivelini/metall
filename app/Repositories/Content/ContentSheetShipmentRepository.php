<?php


namespace App\Repositories\Content;


use App\Repositories\CoreRepository;
use App\Models\Content\ContentSheetShipment as Model;
use App\Helpers\ImageHelper;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Helpers\ModelAttributeHelper;


class ContentSheetShipmentRepository extends CoreRepository
{

    protected $imageHelper;
    private $modelAttributeHelperr;

    public function __construct()
    {
        parent::__construct();
        $this->imageHelper = new ImageHelper();
        $this->modelAttributeHelperr = new ModelAttributeHelper();
    }

    public function getModelClass()
    {
        return Model::class;
    }

    public function getEdit($id) {
        $page = $this->startConditions()
            ->where('id', $id)
            ->with('image:id,path,content_sheet_shipment_id', 'gallery:id,path,content_sheet_shipment_id')
            ->first();

        $this->imageHelper->getImgPathFromModel($page);
        $this->imageHelper->getImgPathGalleryFromModel($page, 'small', true);

        $page->gallery = $page->gallery->chunk(4);

        return $page;
    }

    public function getObject($id)
    {
        $object = $this->startConditions()
            ->where('id', $id)
            ->first();

        return $object;
    }

    public function getShipmentForIndex()
    {
        $pages = $this->startConditions()
            ->select('id', 'company_id', 'h1', 'date', 'point', 'is_published')
            ->where('company_id', Auth::user()->company()->first()->id)
            ->get();

        return $pages;
    }

    public function getShipmentForIndexFrontendFromCompany($company)
    {
        $pages = $this->startConditions()
            ->select('id', 'company_id', 'h1', 'date', 'point', 'is_published')
            ->where('company_id', $company->id)
            ->where('is_published', 1)
            ->with('image:id,path,content_sheet_shipment_id')
            ->get();

        foreach ($pages as $page) {
            $this->imageHelper->getImgPathFromModel($page, 'medium');
            $page->img = !empty($page->image->img) ? $page->image->img : NULL;
        }

        $pages = $this->modelAttributeHelperr->getAttributesFromCollectionModels($pages);

        return $pages;
    }

    public function getObjectForFrontendPage($id)
    {
        $page = $this->startConditions()
            ->where('id', $id)
            ->with('image:id,path,content_sheet_shipment_id', 'gallery:id,path,content_sheet_shipment_id')
            ->first();

        $this->imageHelper->getImgPathFromModel($page, 'medium', true);
        $this->imageHelper->getImgPathGalleryFromModel($page, 'small', true);

        $page->img = !empty($page->image->img_original) ? $page->image->img_original : NULL;
        $page->date = Carbon::make($page->date)->format('d.m.Y');
        $page->products = collect($page->products_json);
        $page->gallery = $this->modelAttributeHelperr->getAttributesFromCollectionModels($page->gallery, ['img', 'img_original']);

        $page = $this->modelAttributeHelperr->getAttributesFromModel($page, ['h1', 'date', 'point', 'content', 'img', 'products', 'gallery']);

        return $page;
    }

}