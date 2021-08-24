<?php


namespace App\Repositories\Catalog;

use App\Repositories\CoreRepository;
use App\Models\CatalogDnishya as Model;

class CatalogDnishaRepository extends CoreRepository
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

            $keyProduct = ['du', 'h'];
            foreach ($keyProduct as $key) {
                $product->$key = rtrim(rtrim($product->$key, '0'), '.');
            }

            if ($product->price == NULL) {
                $product->price = 'По запросу';
            }

            $product->fullName = 'Днище ' . $product->du . 'х' .
                $product->h . ' ' . $product->steel . ' ' . $product->standard;

            return $product;
        });

        return $list;
    }
}