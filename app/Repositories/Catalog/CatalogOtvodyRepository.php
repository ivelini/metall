<?php


namespace App\Repositories\Catalog;

use App\Repositories\CoreRepository;
use App\Models\Catalog\CatalogOtvody as Model;

class CatalogOtvodyRepository extends CoreRepository
{

    public function getModelClass()
    {
        return Model::class;
    }

    public function getAllForCompanyId($id)
    {

        $list = $this->startConditions()
            ->where('company_id', $id)
            ->with(['standardProduct', 'markaStali'])
            ->get();

        $list->map(function ($product) {

            $product->steel = $product->markaStali->name;
            $product->standard = $product->standardProduct->name;

            $keyProduct = ['du', 'h', 'ugol_giba'];
            foreach ($keyProduct as $key) {
                $product->$key = rtrim(rtrim($product->$key, '0'), '.');
            }

            if ($product->price == NULL) {
                $product->price = 'По запросу';
            }

            $product->fullName = 'Отвод '. $product->ugol_giba . ' ' . $product->du . 'х' .
                $product->h . ' ' . $product->steel . ' ' . $product->standard;

            return $product;
        });

//        dd($list->first());
        return $list;
    }
}