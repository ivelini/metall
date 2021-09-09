<?php


namespace App\Repositories\Catalog;

use App\Repositories\CoreRepository;
use App\Models\Catalog\CatalogPerehody as Model;

class CatalogPerehodyRepository extends CoreRepository
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

            $keyProduct = ['du1', 'h1', 'du2', 'h2'];
            foreach ($keyProduct as $key) {
                $product->$key = rtrim(rtrim($product->$key, '0'), '.');
            }

            if ($product->model == NULL) {
                $product->model = 'К';
            }

            if ($product->price == NULL) {
                $product->price = 'По запросу';
            }

            $product->fullName = 'Переход '. $product->model . ' ' . $product->du1 . 'х' .
                $product->h1 . '-' . $product->du2 . 'х' .
                $product->h2 . ' ' . $product->steel . ' ' . $product->standard;

            return $product;
        });

//        dd($list->first());
        return $list;
    }
}