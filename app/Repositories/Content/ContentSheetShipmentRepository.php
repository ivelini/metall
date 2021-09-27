<?php


namespace App\Repositories\Content;


use App\Repositories\CoreRepository;
use App\Models\Content\ContentSheetShipment as Model;
use App\Helpers\ImageHelper;
use Illuminate\Support\Facades\Auth;


class ContentSheetShipmentRepository extends CoreRepository
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

}