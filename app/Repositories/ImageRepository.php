<?php


namespace App\Repositories;

use App\Models\Image as Model;

class ImageRepository extends CoreRepository
{

    public function getModelClass()
    {
        return Model::class;
    }
}