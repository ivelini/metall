<?php

namespace App\Repositories\Catalog;

use App\Repositories\CoreRepository;
use App\Models\Catalog\CatalogStandardsProduct as Model;

class CatalogStandardRepository extends CoreRepository
{
    public function getModelClass()
    {
        return Model::class;
    }

    public function getListNames()
    {
        $list = $this->startConditions()->pluck('name');
        return $list;
    }

    public function getID($name) {
        $id = $this->startConditions()
            ->select('id','name')
            ->where('name', $name)
            ->first()
            ->id;
        return $id;
    }
}