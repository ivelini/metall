<?php


namespace App\Repositories\Settings;

use App\Helpers\ImageHelper;
use App\Models\Settings\Slider as Model;
use App\Repositories\CoreRepository;
use Illuminate\Support\Facades\Auth;

class SliderRepository extends CoreRepository
{
    private $imageHelper;

    public function __construct()
    {
        parent::__construct();
        $this->imageHelper = new ImageHelper();
    }

    public function getModelClass()
    {
        return Model::class;
    }

    public function getSlidersForIndex()
    {
        $pages = $this->startConditions()
            ->select('id', 'company_id', 'h1', 'created_at', 'is_published')
            ->where('company_id', Auth::user()->company->first()->id)
            ->get();

        return $pages;
    }

    public function getPageForEdit($id)
    {
        $page = $this->startConditions()
            ->where('id', $id)
            ->first();

        return $page;
    }

    public function getSliderForShow($id)
    {
        $page = $this->startConditions()
            ->select('id', 'h1', 'description', 'is_published')
            ->where('id', $id)
            ->with(['slides', 'slides.image:id,path,slider_image_id'])
            ->first();

        foreach ($page->slides as $slide) {

            $this->imageHelper->getImgPathFromModel($slide, 'small');
        }

        return $page;
    }
}