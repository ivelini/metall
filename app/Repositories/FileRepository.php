<?php


namespace App\Repositories;

use App\Models\File as Model;

class FileRepository extends CoreRepository
{

    public function getModelClass()
    {
        return Model::class;
    }
}