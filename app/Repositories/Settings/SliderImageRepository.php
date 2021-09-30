<?php


namespace App\Repositories\Settings;

use App\Helpers\ImageHelper;
use App\Models\Settings\SliderImage as Model;
use App\Repositories\CoreRepository;

class SliderImageRepository extends CoreRepository
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

    public function getObject($id)
    {
        $object = $this->startConditions()
            ->where('id', $id)
            ->first();

        return $object;
    }

    public function getNextOrderSlideFromSlider($sliderId)
    {
        $nextOrder = $this->startConditions()
                ->where('slider_id', $sliderId)
                ->max('order') + 1;

        return $nextOrder;
    }

    public function getSlideForEdit($id)
    {
        $object = $this->startConditions()
            ->where('id', $id)
            ->with('image:id,path,slider_image_id')
            ->first();

        $this->imageHelper->getImgPathFromModel($object, 'medium');

        return $object;
    }
}